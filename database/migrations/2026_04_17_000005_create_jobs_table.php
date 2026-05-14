<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->unique();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // sales rep / created by
            $table->string('client_id')->nullable();
            $table->string('quote_id')->nullable(); // if converted from quote
            $table->string('job_title');
            $table->text('instructions')->nullable();
            $table->text('job_notes')->nullable();
            $table->string('job_status')->default('New'); // New, Scheduled, InProgress, Completed, Cancelled
            $table->string('scheduled_status')->default('Unscheduled'); // Unscheduled, Scheduled
            $table->string('assigned_status')->default('Unassigned'); // Unassigned, Assigned
            $table->unsignedBigInteger('team_member_assigned_id')->nullable();
            $table->string('job_conversion_type')->nullable(); // system, manual
            $table->string('job_converted_by')->nullable();
            $table->string('invoicing_reminder')->nullable();
            $table->string('schedule_later')->default('no'); // yes, no
            $table->timestamp('job_date_time')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('job_items', function (Blueprint $table) {
            $table->id();
            $table->string('job_id'); // references crm_jobs.job_id
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('scheduled_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->unique();
            $table->timestamp('scheduled_date')->nullable();
            $table->timestamp('scheduled_end')->nullable();
            $table->string('status')->default('Pending'); // Pending, Confirmed, Completed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_jobs');
        Schema::dropIfExists('job_items');
        Schema::dropIfExists('crm_jobs');
    }
};




