<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recurring_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('recurring_invoices', 'job_id')) {
                $table->string('job_id', 30)->nullable()->after('client_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recurring_invoices', function (Blueprint $table) {
            $table->dropColumn('job_id');
        });
    }
};
