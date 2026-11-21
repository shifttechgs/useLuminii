<?php

namespace Tests\Feature;

use App\Mail\ContactFormMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DemoBookingEmailTest extends TestCase
{
    use RefreshDatabase;

    private function book(array $overrides = [])
    {
        return $this->postJson(route('demo.submit'), array_merge([
            'fullname' => 'Amina Dlamini',
            'email' => 'amina@example.com',
            'business_type' => 'Plumbing',
            'team_size' => '2–5 people',
            'pain_point' => 'Chasing late payments',
            'current_tools' => 'WhatsApp, spreadsheets',
        ], $overrides));
    }

    public function test_enquiry_recipients_are_sales_with_a_copy_to_the_gmail_inbox(): void
    {
        $this->assertSame('sales@shifttechgs.com', config('mail.notifications.to'));
        $this->assertSame(['shifttechgs1@gmail.com'], config('mail.notifications.cc'));
    }

    public function test_a_demo_booking_emails_sales_and_copies_the_gmail_inbox(): void
    {
        Mail::fake();

        $this->book()->assertOk()->assertJson(['email_sent' => true]);

        Mail::assertSent(ContactFormMail::class, 1);
        Mail::assertSent(ContactFormMail::class, fn (ContactFormMail $mail) =>
            $mail->hasTo('sales@shifttechgs.com')
            && $mail->hasCc('shifttechgs1@gmail.com')
            && $mail->data['business_type'] === 'Plumbing'
            && $mail->data['subject'] === 'New demo request: Amina Dlamini (Plumbing, 2–5 people)');
    }

    public function test_the_booking_email_has_its_own_subject_and_replies_go_to_the_prospect(): void
    {
        $mail = new ContactFormMail([
            'fullname' => 'Amina Dlamini',
            'email' => 'amina@example.com',
            'subject' => 'New demo request: Amina Dlamini (Plumbing, 2–5 people)',
            'message' => 'Chasing late payments',
            'business_type' => 'Plumbing',
            'team_size' => '2–5 people',
        ]);

        $mail->assertHasSubject('New demo request: Amina Dlamini (Plumbing, 2–5 people)');
        $mail->assertHasReplyTo('amina@example.com', 'Amina Dlamini');
        $mail->assertSeeInHtml('Amina Dlamini wants a demo.');
        $mail->assertSeeInHtml('Reply to Amina');
        $mail->assertSeeInText('NEW DEMO REQUEST');
    }

    public function test_an_invalid_booking_sends_nothing(): void
    {
        Mail::fake();

        $this->book(['email' => 'not-an-email'])->assertStatus(422);

        Mail::assertNothingSent();
    }
}
