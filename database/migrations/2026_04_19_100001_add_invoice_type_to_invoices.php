<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // project | hosting | consultation | domain | maintenance | other | recurring
            $table->string('invoice_type', 30)->default('project')->after('job_id');
        });

        Schema::table('recurring_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('recurring_invoices', 'title')) {
                $table->string('title')->nullable()->after('recurring_invoice_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_type');
        });
        Schema::table('recurring_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('recurring_invoices', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
