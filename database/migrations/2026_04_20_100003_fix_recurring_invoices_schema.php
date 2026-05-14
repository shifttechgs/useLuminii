<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recurring_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('recurring_invoices', 'frequency')) {
                $table->string('frequency', 30)->default('Monthly')->after('job_id');
            }
            if (!Schema::hasColumn('recurring_invoices', 'balance')) {
                $table->decimal('balance', 10, 2)->nullable()->after('total_amount');
            }
            if (!Schema::hasColumn('recurring_invoices', 'deposit_paid')) {
                $table->decimal('deposit_paid', 10, 2)->nullable()->after('balance');
            }
            if (!Schema::hasColumn('recurring_invoices', 'payment_due')) {
                $table->decimal('payment_due', 10, 2)->nullable()->after('deposit_paid');
            }
            if (!Schema::hasColumn('recurring_invoices', 'status')) {
                $table->string('status', 30)->default('Active')->after('payment_due');
            }
            if (!Schema::hasColumn('recurring_invoices', 'client_message')) {
                $table->text('client_message')->nullable()->after('internal_notes');
            }
            if (!Schema::hasColumn('recurring_invoices', 'created_by')) {
                $table->string('created_by')->nullable()->after('client_message');
            }
            if (!Schema::hasColumn('recurring_invoices', 'invoices_generated')) {
                $table->integer('invoices_generated')->default(0)->after('next_invoice_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recurring_invoices', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('recurring_invoices', 'frequency')          ? 'frequency'          : null,
                Schema::hasColumn('recurring_invoices', 'balance')            ? 'balance'            : null,
                Schema::hasColumn('recurring_invoices', 'deposit_paid')       ? 'deposit_paid'       : null,
                Schema::hasColumn('recurring_invoices', 'payment_due')        ? 'payment_due'        : null,
                Schema::hasColumn('recurring_invoices', 'status')             ? 'status'             : null,
                Schema::hasColumn('recurring_invoices', 'client_message')     ? 'client_message'     : null,
                Schema::hasColumn('recurring_invoices', 'created_by')         ? 'created_by'         : null,
                Schema::hasColumn('recurring_invoices', 'invoices_generated') ? 'invoices_generated' : null,
            ]));
        });
    }
};
