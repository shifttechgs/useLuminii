<?php

namespace Tests\Feature;

use App\Filament\Widgets\PersonalFunnelWidget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PersonalMetricsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_allowed_events(): void
    {
        foreach (['visit', 'pdf_download', 'send_click'] as $event) {
            $this->postJson(route('personal.metric'), ['event' => $event, 'doc_type' => 'invoice'])->assertNoContent();
        }

        $this->assertSame(3, DB::table('personal_events')->count());
        $this->assertSame('invoice', DB::table('personal_events')->where('event', 'pdf_download')->value('doc_type'));
    }

    public function test_it_rejects_unknown_events_and_server_only_events(): void
    {
        $this->postJson(route('personal.metric'), ['event' => 'hack'])->assertStatus(422);
        // email_left is only recorded by the server when a lead is created
        $this->postJson(route('personal.metric'), ['event' => 'email_left'])->assertStatus(422);

        $this->assertSame(0, DB::table('personal_events')->count());
    }

    public function test_a_new_early_access_lead_counts_as_email_left_once(): void
    {
        $payload = [
            'email' => 'metrics@example.com', 'name' => '', 'business' => 'Acme',
            'doc_type' => 'quote', 'currency' => 'USD', 'lines' => 1, 'total' => 10, 'timezone' => 'UTC',
        ];
        $this->postJson(route('personal.early-access'), $payload)->assertOk();
        $this->postJson(route('personal.early-access'), $payload)->assertOk();   // repeat within a day: no new lead

        $this->assertSame(1, DB::table('personal_events')->where('event', 'email_left')->count());
    }

    public function test_funnel_rates_are_computed_against_visitors(): void
    {
        $rows = [];
        foreach (['visit' => 10, 'pdf_download' => 4, 'send_click' => 2, 'email_left' => 1] as $event => $n) {
            for ($i = 0; $i < $n; $i++) {
                $rows[] = ['event' => $event, 'doc_type' => null, 'created_at' => now()->subDay()];
            }
        }
        DB::table('personal_events')->insert($rows);

        $stats = (fn () => $this->getStats())->call(new PersonalFunnelWidget());
        $values = array_map(fn ($s) => (string) $s->getValue(), $stats);

        $this->assertSame(['10', '40%', '20%', '10%'], $values);
    }
}
