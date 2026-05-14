<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add indexes on every column used in WHERE, ORDER BY, or GROUP BY across
 * widgets, resources, and the Reports page. None of these existed before,
 * so every filtered query was doing a full table scan.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── invoices ────────────────────────────────────────────────────────
        Schema::table('invoices', function (Blueprint $table) {
            if (! $this->hasIndex('invoices', 'invoices_status_index'))
                $table->index('status');
            if (! $this->hasIndex('invoices', 'invoices_client_id_index'))
                $table->index('client_id');
            if (! $this->hasIndex('invoices', 'invoices_paid_at_index'))
                $table->index('paid_at');
            if (! $this->hasIndex('invoices', 'invoices_invoice_date_index'))
                $table->index('invoice_date');
            if (! $this->hasIndex('invoices', 'invoices_due_date_index'))
                $table->index('due_date');
        });

        // ── jobs (crm jobs, not queue jobs) ─────────────────────────────────
        Schema::table('jobs', function (Blueprint $table) {
            if (! Schema::hasColumn('jobs', 'job_status')) return; // guard: queue jobs table has no job_status
            if (! $this->hasIndex('jobs', 'jobs_job_status_index'))
                $table->index('job_status');
            if (! $this->hasIndex('jobs', 'jobs_client_id_index'))
                $table->index('client_id');
            if (! $this->hasIndex('jobs', 'jobs_assigned_status_index'))
                $table->index('assigned_status');
            if (! $this->hasIndex('jobs', 'jobs_job_date_time_index'))
                $table->index('job_date_time');
        });

        // ── quotes ──────────────────────────────────────────────────────────
        Schema::table('quotes', function (Blueprint $table) {
            if (! $this->hasIndex('quotes', 'quotes_status_index'))
                $table->index('status');
            if (! $this->hasIndex('quotes', 'quotes_client_id_index'))
                $table->index('client_id');
        });

        // ── expenses ────────────────────────────────────────────────────────
        Schema::table('expenses', function (Blueprint $table) {
            if (! $this->hasIndex('expenses', 'expenses_expense_date_index'))
                $table->index('expense_date');
            if (! $this->hasIndex('expenses', 'expenses_category_id_index'))
                $table->index('category_id');
        });

        // ── business_clients ────────────────────────────────────────────────
        Schema::table('business_clients', function (Blueprint $table) {
            if (! $this->hasIndex('business_clients', 'business_clients_client_type_index'))
                $table->index('client_type');
            if (! $this->hasIndex('business_clients', 'business_clients_lead_source_index'))
                $table->index('lead_source');
        });

        // ── recurring_invoices ───────────────────────────────────────────────
        Schema::table('recurring_invoices', function (Blueprint $table) {
            if (! $this->hasIndex('recurring_invoices', 'recurring_invoices_is_active_index'))
                $table->index('is_active');
            if (! $this->hasIndex('recurring_invoices', 'recurring_invoices_client_id_index'))
                $table->index('client_id');
            if (! $this->hasIndex('recurring_invoices', 'recurring_invoices_next_invoice_date_index'))
                $table->index('next_invoice_date');
        });

        // ── contact_form_submissions ─────────────────────────────────────────
        Schema::table('contact_form_submissions', function (Blueprint $table) {
            if (! $this->hasIndex('contact_form_submissions', 'contact_form_submissions_status_index'))
                $table->index('status');
        });

        // ── client_requests ─────────────────────────────────────────────────
        if (Schema::hasTable('client_requests')) {
            Schema::table('client_requests', function (Blueprint $table) {
                if (! $this->hasIndex('client_requests', 'client_requests_status_index'))
                    $table->index('status');
                if (! $this->hasIndex('client_requests', 'client_requests_client_id_index'))
                    $table->index('client_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('invoices',              fn ($t) => $t->dropIndex(['status', 'client_id', 'paid_at', 'invoice_date', 'due_date']));
        Schema::table('quotes',                fn ($t) => $t->dropIndex(['status', 'client_id']));
        Schema::table('expenses',              fn ($t) => $t->dropIndex(['expense_date', 'category_id']));
        Schema::table('business_clients',      fn ($t) => $t->dropIndex(['client_type', 'lead_source']));
        Schema::table('recurring_invoices',    fn ($t) => $t->dropIndex(['is_active', 'client_id', 'next_invoice_date']));
        Schema::table('contact_form_submissions', fn ($t) => $t->dropIndex(['status']));
    }

    private function hasIndex(string $table, string $index): bool
    {
        return collect(\DB::select("SHOW INDEX FROM `{$table}`"))
            ->pluck('Key_name')
            ->contains($index);
    }
};
