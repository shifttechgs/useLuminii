<?php

namespace Tests\Feature;

use App\Filament\Widgets\PersonalVotesWidget;
use App\Mail\PersonalEarlyAccessMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PersonalEarlyAccessMailAndVotesTest extends TestCase
{
    use RefreshDatabase;

    private function signUp(string $email, ?string $wants = null, array $extra = [])
    {
        return $this->postJson(route('personal.early-access'), array_merge([
            'email' => $email, 'name' => 'Sam', 'business' => 'Acme',
            'doc_type' => 'invoice', 'currency' => 'USD', 'lines' => 1, 'total' => 10, 'timezone' => 'UTC',
            'wants' => $wants,
        ], $extra));
    }

    public function test_a_new_sign_up_gets_one_confirmation_email_with_their_vote(): void
    {
        Mail::fake();

        $this->signUp('one@example.com', 'remind')->assertOk();
        $this->signUp('one@example.com', 'pay')->assertOk();   // repeat within a day: no second email

        Mail::assertSent(PersonalEarlyAccessMail::class, 1);
        Mail::assertSent(PersonalEarlyAccessMail::class, fn ($m) =>
            $m->hasTo('one@example.com') && $m->vote === 'Automatic payment reminders' && $m->name === 'Sam');
    }

    public function test_spam_trap_submissions_get_no_email(): void
    {
        Mail::fake();

        $this->signUp('bot@example.com', null, ['website' => 'spam.example'])->assertOk();

        Mail::assertNothingSent();
    }

    public function test_a_mail_failure_does_not_fail_the_sign_up(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $this->signUp('two@example.com', 'pay')->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('leads', ['email' => 'two@example.com']);
    }

    public function test_the_email_renders(): void
    {
        $html = (new PersonalEarlyAccessMail('Sam', 'Pay button (card or mobile money)'))->render();

        $this->assertStringContainsString("You're on the list", $html);
        $this->assertStringContainsString('Pay button (card or mobile money)', $html);
        $this->assertStringContainsString('/personal', $html);
    }

    public function test_votes_are_tallied_from_early_access_leads(): void
    {
        Mail::fake();

        $this->signUp('a@example.com', 'pay')->assertOk();
        $this->signUp('b@example.com', 'pay')->assertOk();
        $this->signUp('c@example.com', 'remind')->assertOk();
        $this->signUp('d@example.com')->assertOk();            // no vote
        $this->signUp('a@example.com', 'track')->assertOk();   // a@ changes their vote

        $tally = PersonalVotesWidget::tally();

        $this->assertSame(1, $tally['Pay button (card or mobile money)']);
        $this->assertSame(1, $tally['Automatic payment reminders']);
        $this->assertSame(1, $tally['Know when the client opens it']);
        $this->assertSame(0, $tally['Client accepts the quote online']);
    }
}
