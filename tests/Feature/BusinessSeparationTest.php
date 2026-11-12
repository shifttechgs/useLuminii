<?php

namespace Tests\Feature;

use App\Filament\Widgets\PersonalFunnelWidget;
use App\Filament\Widgets\PersonalVotesWidget;
use App\Models\BusinessClient;
use App\Models\BusinessSetup;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Quote;
use App\Models\User;
use App\Support\BusinessRules;
use App\Support\CurrentBusiness;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * One business must never see, change or link to another business's data.
 */
class BusinessSeparationTest extends TestCase
{
    use RefreshDatabase;

    private User $userA;
    private User $userB;
    private User $platformAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        CurrentBusiness::set(null);

        $this->platformAdmin = $this->makeUser('ST-001', 'admin@platform.test', 'SuperAdmin');
        $this->userA = $this->makeUser('BUS-A', 'owner@a.test', 'Admin');
        $this->userB = $this->makeUser('BUS-B', 'owner@b.test', 'Admin');
    }

    protected function tearDown(): void
    {
        CurrentBusiness::set(null);
        parent::tearDown();
    }

    private function makeUser(string $businessId, string $email, string $role): User
    {
        return User::allBusinesses()->create([
            'business_id' => $businessId, 'name' => $email, 'email' => $email,
            'password' => bcrypt('password-for-tests'), 'role' => $role, 'is_active' => true,
        ]);
    }

    /** Creates a client, a quote and an invoice for the given user's business. */
    private function seedBusiness(User $user, string $tag): array
    {
        $this->actingAs($user);
        $client = BusinessClient::create(['firstname' => $tag, 'lastname' => 'Client', 'email' => strtolower($tag) . '@client.test']);
        $quote = Quote::create(['client_id' => $client->client_id, 'job_title' => "$tag job", 'status' => 'Draft']);
        $invoice = Invoice::create(['client_id' => $client->client_id, 'status' => 'Draft', 'view_token' => 'tok-' . strtolower($tag)]);
        app('auth')->forgetGuards();

        return compact('client', 'quote', 'invoice');
    }

    public function test_new_records_get_the_signed_in_users_business(): void
    {
        $a = $this->seedBusiness($this->userA, 'A');

        $this->assertSame('BUS-A', $a['client']->business_id);
        $this->assertSame('BUS-A', $a['quote']->business_id);
        $this->assertSame('BUS-A', $a['invoice']->business_id);
    }

    public function test_each_business_sees_only_its_own_records(): void
    {
        $this->seedBusiness($this->userA, 'A');
        $this->seedBusiness($this->userB, 'B');

        $this->actingAs($this->userA);
        $this->assertSame(['A'], BusinessClient::pluck('firstname')->all());
        $this->assertSame(1, Quote::count());
        $this->assertSame(1, Invoice::count());
        $this->assertSame(['owner@a.test'], User::pluck('email')->all());

        app('auth')->forgetGuards();
        $this->actingAs($this->userB);
        $this->assertSame(['B'], BusinessClient::pluck('firstname')->all());
    }

    public function test_a_signed_in_user_without_a_business_sees_nothing(): void
    {
        $this->seedBusiness($this->userA, 'A');
        $orphan = $this->makeUser('BUS-X', 'orphan@x.test', 'Admin');
        $orphan->forceFill(['business_id' => null])->saveQuietly();

        $this->actingAs($orphan->fresh());
        $this->assertSame(0, BusinessClient::count());
        $this->assertSame(0, Quote::count());
        $this->assertSame('', BusinessSetup::current()->business_name);
    }

    public function test_another_business_record_cannot_be_opened_by_url(): void
    {
        $b = $this->seedBusiness($this->userB, 'B');

        $this->actingAs($this->userA)
            ->get(route('crm.quotes.show', $b['quote']))
            ->assertNotFound();
    }

    public function test_forms_cannot_link_to_another_business_record(): void
    {
        $b = $this->seedBusiness($this->userB, 'B');
        $this->actingAs($this->userA);

        $rules = ['client_id' => [BusinessRules::exists('business_clients', 'client_id')]];
        $this->assertTrue(Validator::make(['client_id' => $b['client']->client_id], $rules)->fails());

        app('auth')->forgetGuards();
        $this->actingAs($this->userB);
        $this->assertFalse(Validator::make(['client_id' => $b['client']->client_id], $rules)->fails());
    }

    public function test_records_created_without_a_user_take_their_parents_business(): void
    {
        $b = $this->seedBusiness($this->userB, 'B');
        $this->assertNull(CurrentBusiness::id());   // e.g. PayPal webhook or client hub

        $payment = Payment::create([
            'invoice_id' => $b['invoice']->invoice_id, 'client_id' => $b['client']->client_id,
            'amount' => 10, 'received_at' => now(),
        ]);

        $this->assertSame('BUS-B', $payment->business_id);
    }

    public function test_settings_never_show_another_business_details(): void
    {
        $this->actingAs($this->userA);
        $settings = BusinessSetup::current();

        $this->assertSame('BUS-A', $settings->business_id);
        $this->assertNotSame('ShiftTech Global Solutions', $settings->business_name);
        $this->assertNull($settings->bank_account_name);

        app('auth')->forgetGuards();
        $this->actingAs($this->platformAdmin);
        $this->assertSame('ShiftTech Global Solutions', BusinessSetup::current()->business_name);
    }

    public function test_the_client_hub_works_for_any_business_and_uses_that_business(): void
    {
        $b = $this->seedBusiness($this->userB, 'B');

        $this->get(route('client-hub.invoice', $b['invoice']->view_token))->assertOk();
        // The request switched to the invoice's business, and resets afterwards
        $this->assertNull(CurrentBusiness::id());
    }

    public function test_scheduled_jobs_notify_each_business_separately(): void
    {
        foreach ([$this->userA, $this->userB] as $i => $user) {
            $this->actingAs($user);
            $client = BusinessClient::create(['firstname' => "C$i", 'lastname' => 'X']);
            Invoice::create(['client_id' => $client->client_id, 'status' => 'Sent', 'due_date' => now()->subDays(3)]);
            app('auth')->forgetGuards();
        }

        $this->artisan('crm:overdue-invoices')->assertSuccessful();

        $this->assertSame(2, Invoice::allBusinesses()->where('status', 'Overdue')->count());
        $overdue = Notification::allBusinesses()->where('title', 'like', '%are now overdue%')->pluck('business_id')->sort()->values()->all();
        // One summary per business, each with only that business's count
        $this->assertSame(['BUS-A', 'BUS-B'], $overdue);
        $this->assertSame(0, Notification::allBusinesses()->where('business_id', 'ST-001')->count());
    }

    public function test_website_forms_always_go_to_the_platform_even_when_signed_in(): void
    {
        Mail::fake();
        $this->actingAs($this->userB);

        $this->postJson(route('personal.early-access'), [
            'email' => 'visitor@example.com', 'doc_type' => 'quote', 'currency' => 'USD',
        ])->assertOk();

        $this->assertSame('ST-001', Lead::allBusinesses()->where('email', 'visitor@example.com')->value('business_id'));
    }

    public function test_platform_widgets_are_hidden_from_other_businesses(): void
    {
        $this->actingAs($this->userA);
        $this->assertFalse(PersonalFunnelWidget::canView());
        $this->assertFalse(PersonalVotesWidget::canView());

        app('auth')->forgetGuards();
        $this->actingAs($this->platformAdmin);
        $this->assertTrue(PersonalFunnelWidget::canView());
        $this->assertTrue(PersonalVotesWidget::canView());
    }

    public function test_create_business_command_sets_up_a_separate_business(): void
    {
        putenv('LUMINII_OWNER_PASSWORD=a-long-test-password');
        $_ENV['LUMINII_OWNER_PASSWORD'] = $_SERVER['LUMINII_OWNER_PASSWORD'] = 'a-long-test-password';

        try {
            $this->artisan('crm:create-business', ['name' => 'Acme Plumbing', 'owner_email' => 'sam@acme.test'])
                ->assertSuccessful();
        } finally {
            putenv('LUMINII_OWNER_PASSWORD');
            unset($_ENV['LUMINII_OWNER_PASSWORD'], $_SERVER['LUMINII_OWNER_PASSWORD']);
        }

        $owner = User::allBusinesses()->where('email', 'sam@acme.test')->firstOrFail();
        $this->assertStringStartsWith('BUS-', $owner->business_id);

        $this->actingAs($owner);
        $this->assertSame('Acme Plumbing', BusinessSetup::current()->business_name);
        $this->assertSame(12, \App\Models\ExpenseCategory::count());
        $this->assertSame(0, BusinessClient::count());
    }
}
