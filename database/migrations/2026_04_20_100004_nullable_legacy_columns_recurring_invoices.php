<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recurring_invoices', function (Blueprint $table) {
            // Legacy columns from the original schema that have no default — make them nullable
            if (Schema::hasColumn('recurring_invoices', 'job_title')) {
                $table->string('job_title')->nullable()->default(null)->change();
            }
            if (Schema::hasColumn('recurring_invoices', 'title')) {
                $table->string('title')->nullable()->default(null)->change();
            }
            if (Schema::hasColumn('recurring_invoices', 'description')) {
                $table->text('description')->nullable()->default(null)->change();
            }
            if (Schema::hasColumn('recurring_invoices', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->default(null)->change();
            }
            if (Schema::hasColumn('recurring_invoices', 'recurrence_type')) {
                $table->string('recurrence_type')->nullable()->default(null)->change();
            }
            if (Schema::hasColumn('recurring_invoices', 'is_active')) {
                $table->boolean('is_active')->nullable()->default(null)->change();
            }
        });
    }

    public function down(): void {}
};
