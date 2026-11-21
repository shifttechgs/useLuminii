<?php

namespace Tests\Feature;

use App\Models\BusinessClient;
use App\Models\BusinessSetup;
use App\Models\Lead;
use App\Models\Subscription;
use App\Models\User;
use App\Support\CurrentBusiness;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Self-serve sign-up: a new business on a 14-day trial, plan gating, seats and
 * read-only once the trial ends.
 */
class SelfServeSignupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CurrentBusiness::set(null);
        Mail::fake();
        Notification::fake();
    }

    protected function tearDown(): void
    {
        CurrentBusiness::set(null);
        parent::tearDown();
    }

    private function signup(array $overrides = [])
    {
        return $this->post(route('signup.store'), array_merge([
            'name'          => 'Sam Doe',
            'business_name' => 'Acme Plumbing',
            'email'         => 'sam@acme.test',
            'phone'         => '0820000000',
            'password'      => 'pipes4ever',
            'plan'          => 'business',
            'interval'      => 'monthly',
        ], $overrides));
    }

    /** A business with an owner and a subscription in the given state. */
    private function business(string $id, array $subscription, int $users = 1): User
    {
        $owner = null;
        for ($i = 0; $i < $users; $i++) {
            $u = User::allBusinesses()->create([
                'business_id' => $id, 'name' => "User $i", 'email' => strtolower($id) . "-$i@test.test",
                'password' => bcrypt('password-for-tests'), 'role' => 'Admin', 'is_active' => true,
            ]);
            $owner ??= $u;
        }
        Subscription::allBusinesses()->create(array_merge(['business_id' => $id, 'interval' => 'monthly'], $subscription));

        return $owner;
    }

    public function test_signup_page_shows_both_plans(): void
    {
        $this->get(route('signup', ['plan' => 'starter', 'interval' => 'annual']))
            ->assertOk()
            ->assertSee('Start your 14-day trial')
            ->assertSee('Starter')
            ->assertSee('Business');
    }

    public function test_signup_creates_a_separate_business_on_a_trial_and_signs_in(): void
    {
        $this->signup()->assertRedirect(route('crm.dashboard'));

        $user = User::allBusinesses()->where('email', 'sam@acme.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertStringStartsWith('BUS-', $user->business_id);
        $this->assertSame('Admin', $user->role);
        $this->assertNull($user->email_verified_at);

        $setup = BusinessSetup::allBusinesses()->where('business_id', $user->business_id)->firstOrFail();
        $this->assertSame('Acme Plumbing', $setup->business_name);

        $sub = Subscription::allBusinesses()->where('business_id', $user->business_id)->firstOrFail();
        $this->assertSame('trialing', $sub->status);
        $this->assertSame('business', $sub->plan);
        $this->assertFalse($sub->complimentary);
        $this->assertTrue($sub->trial_ends_at->between(now()->addDays(13), now()->addDays(15)));

        Notification::assertSentTo($user, VerifyEmail::class);

        // The platform team sees the sign-up as a lead in its own business
        $lead = Lead::allBusinesses()->where('email', 'sam@acme.test')->firstOrFail();
        $this->assertSame(CurrentBusiness::platform(), $lead->business_id);
        $this->assertSame('Acme Plumbing', $lead->company);
    }

    public function test_signup_rejects_an_existing_email_and_weak_password(): void
    {
        $this->business('BUS-OLD', ['plan' => 'business', 'status' => 'active', 'complimentary' => true]);

        $this->signup(['email' => 'bus-old-0@test.test', 'password' => 'short'])
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertSame(1, User::allBusinesses()->count());
    }

    public function test_honeypot_submissions_create_nothing(): void
    {
        $this->signup(['company_website' => 'http://spam.example'])->assertRedirect(route('signup'));

        $this->assertSame(0, User::allBusinesses()->count());
        $this->assertGuest();
    }

    public function test_a_new_business_sees_none_of_another_businesses_data(): void
    {
        $other = $this->business('BUS-OTHER', ['plan' => 'business', 'status' => 'active', 'complimentary' => true]);
        $this->actingAs($other);
        BusinessClient::create(['firstname' => 'Hidden', 'lastname' => 'Client', 'email' => 'hidden@client.test']);
        app('auth')->forgetGuards();

        $this->signup();
        $this->assertSame(0, BusinessClient::count());
    }

    public function test_trials_include_business_sections(): void
    {
        $owner = $this->business('BUS-TRIAL', ['plan' => 'starter', 'status' => 'trialing', 'trial_ends_at' => now()->addDays(10)]);

        $this->actingAs($owner)->get(route('crm.quotes.index'))->assertOk();
    }

    public function test_starter_plan_gets_an_upgrade_page_for_business_sections(): void
    {
        $owner = $this->business('BUS-STARTER', ['plan' => 'starter', 'status' => 'active']);

        $this->actingAs($owner)->get(route('crm.jobs.index'))
            ->assertForbidden()
            ->assertSee('Jobs is part of Business');
        $this->actingAs($owner)->get(route('crm.reports'))->assertForbidden();

        // Quotes and invoices are part of Starter
        $this->actingAs($owner)->get(route('crm.quotes.index'))->assertOk();
        $this->actingAs($owner)->get(route('crm.invoices.index'))->assertOk();
        $this->actingAs($owner)->get(route('crm.clients.index'))->assertOk();
    }

    public function test_an_ended_trial_is_read_only_but_billing_still_opens(): void
    {
        $owner = $this->business('BUS-ENDED', ['plan' => 'business', 'status' => 'trialing', 'trial_ends_at' => now()->subDay()]);

        $this->actingAs($owner)
            ->post(route('crm.clients.store'), ['firstname' => 'New', 'lastname' => 'Client', 'email' => 'new@client.test'])
            ->assertRedirect(route('crm.billing'));
        $this->assertSame(0, BusinessClient::allBusinesses()->count());

        $this->actingAs($owner)->get(route('crm.billing'))->assertOk()->assertSee('Your account is read-only');
        $this->actingAs($owner)->get(route('crm.clients.index'))->assertOk();
    }

    public function test_seat_limit_blocks_extra_users_on_starter(): void
    {
        $owner = $this->business('BUS-SOLO', ['plan' => 'starter', 'status' => 'active']);

        $this->actingAs($owner)
            ->from(route('crm.team.create'))
            ->post(route('crm.team.store'), ['name' => 'Second', 'email' => 'second@solo.test', 'role' => 'Technician'])
            ->assertRedirect(route('crm.team.create'))
            ->assertSessionHas('error');

        $this->assertSame(1, User::allBusinesses()->where('business_id', 'BUS-SOLO')->count());
    }

    public function test_business_plan_allows_three_users(): void
    {
        $owner = $this->business('BUS-TEAM', ['plan' => 'business', 'status' => 'active'], users: 2);

        $this->actingAs($owner)
            ->post(route('crm.team.store'), ['name' => 'Third', 'email' => 'third@team.test', 'role' => 'Technician'])
            ->assertSessionHasNoErrors();

        $this->assertSame(3, User::allBusinesses()->where('business_id', 'BUS-TEAM')->count());
    }

    public function test_businesses_set_up_by_hand_are_complimentary(): void
    {
        putenv('LUMINII_OWNER_PASSWORD=a-long-test-password');
        $this->artisan('crm:create-business', ['name' => 'Hand Made', 'owner_email' => 'owner@hand.test'])->assertSuccessful();
        putenv('LUMINII_OWNER_PASSWORD');

        $user = User::allBusinesses()->where('email', 'owner@hand.test')->firstOrFail();
        $sub = Subscription::allBusinesses()->where('business_id', $user->business_id)->firstOrFail();
        $this->assertTrue($sub->complimentary);
        $this->assertSame('active', $sub->status);
    }
}
