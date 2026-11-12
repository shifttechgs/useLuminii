<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Per-business data separation (see App\Models\Concerns\BelongsToBusiness).
 *
 * - Adds business_id to the tables that were missing it.
 * - Indexes business_id wherever it is queried.
 * - Gives every existing row without a business the platform business.
 */
return new class extends Migration
{
    /** Tables that get a new business_id column. */
    private const NEW_COLUMN = ['payments', 'scheduled_jobs', 'quote_comments', 'job_status_logs', 'leads', 'contact_form_submissions'];

    /** Every table filtered by business_id. */
    private const ALL = [
        'activity_logs', 'business_clients', 'business_services', 'business_setup', 'client_requests',
        'contact_form_submissions', 'crm_jobs', 'expense_categories', 'expenses', 'invoices', 'job_status_logs',
        'leads', 'notifications', 'payments', 'quote_comments', 'quotes', 'recurring_invoices', 'scheduled_jobs',
        'team_members', 'users',
    ];

    public function up(): void
    {
        foreach (self::NEW_COLUMN as $table) {
            if (! Schema::hasColumn($table, 'business_id')) {
                Schema::table($table, fn (Blueprint $t) => $t->string('business_id', 30)->nullable()->after('id'));
            }
        }

        $platform = config('crm.business_id', 'ST-001');

        foreach (self::ALL as $table) {
            DB::table($table)->whereNull('business_id')->update(['business_id' => $platform]);

            // business_setup.business_id is already unique (and so indexed)
            if ($table !== 'business_setup' && ! Schema::hasIndex($table, $table . '_business_id_index')) {
                Schema::table($table, fn (Blueprint $t) => $t->index('business_id'));
            }
        }
    }

    public function down(): void
    {
        foreach (self::ALL as $table) {
            if ($table !== 'business_setup' && Schema::hasIndex($table, $table . '_business_id_index')) {
                Schema::table($table, fn (Blueprint $t) => $t->dropIndex(['business_id']));
            }
        }
        foreach (self::NEW_COLUMN as $table) {
            if (Schema::hasColumn($table, 'business_id')) {
                Schema::table($table, fn (Blueprint $t) => $t->dropColumn('business_id'));
            }
        }
    }
};
