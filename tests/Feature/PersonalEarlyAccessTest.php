<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalEarlyAccessTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $extra = []): array
    {
        return array_merge([
            'email'    => 'vote-test@example.com',
            'name'     => '',
            'business' => 'Acme Studio',
            'doc_type' => 'invoice',
            'currency' => 'USD',
            'lines'    => 1,
            'total'    => 450,
            'timezone' => 'Africa/Johannesburg',
        ], $extra);
    }

    public function test_it_stores_the_vote_on_a_new_lead(): void
    {
        $this->postJson(route('personal.early-access'), $this->payload(['wants' => 'pay']))
            ->assertOk()->assertJson(['success' => true]);

        $lead = Lead::where('email', 'vote-test@example.com')->firstOrFail();
        $this->assertSame(['Personal: quotes and invoices', 'Wants: Pay button (card or mobile money)'], $lead->services_interested);
        $this->assertStringContainsString('Wants: Pay button (card or mobile money).', $lead->message);
        $this->assertSame('Acme Studio', $lead->name);
    }

    public function test_the_vote_is_optional(): void
    {
        $this->postJson(route('personal.early-access'), $this->payload())->assertOk();

        $lead = Lead::where('email', 'vote-test@example.com')->firstOrFail();
        $this->assertSame(['Personal: quotes and invoices'], $lead->services_interested);
    }

    public function test_a_repeat_within_a_day_updates_the_vote_instead_of_adding_a_lead(): void
    {
        $this->postJson(route('personal.early-access'), $this->payload(['wants' => 'pay']))->assertOk();
        $this->postJson(route('personal.early-access'), $this->payload(['wants' => 'remind']))->assertOk();

        $this->assertSame(1, Lead::where('email', 'vote-test@example.com')->count());
        $this->assertSame(
            ['Personal: quotes and invoices', 'Wants: Automatic payment reminders'],
            Lead::where('email', 'vote-test@example.com')->first()->services_interested
        );
    }

    public function test_an_unknown_choice_is_rejected(): void
    {
        $this->postJson(route('personal.early-access'), $this->payload(['wants' => 'crypto']))
            ->assertStatus(422)->assertJsonValidationErrors('wants');

        $this->assertSame(0, Lead::count());
    }

    public function test_the_honeypot_saves_nothing(): void
    {
        $this->postJson(route('personal.early-access'), $this->payload(['website' => 'spam.example']))->assertOk();

        $this->assertSame(0, Lead::count());
    }
}
