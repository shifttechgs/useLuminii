<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_id', 20)->unique();

            // Source of the lead
            $table->string('source', 30)->default('manual'); // website|manual|call|referral|email|social

            // Contact details
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();

            // Lead intent
            $table->text('services_interested')->nullable(); // comma-separated
            $table->text('message')->nullable();
            $table->decimal('budget', 14, 2)->nullable();

            // Pipeline
            $table->string('status', 30)->default('New'); // New|Contacted|Qualified|Proposal Sent|Converted|Closed
            $table->string('priority', 20)->default('Normal'); // Low|Normal|High|Urgent

            // Internal
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->unsignedBigInteger('converted_client_id')->nullable();

            // Tracking
            $table->string('ip_address')->nullable();
            $table->string('original_ref')->nullable(); // old CF- or submission ID

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('source');
            $table->index('assigned_to');
        });

        // Migrate existing contact_form_submissions into leads
        if (Schema::hasTable('contact_form_submissions')) {
            DB::table('contact_form_submissions')->orderBy('id')->each(function ($row) {
                $statusMap = ['Contacted' => 'Contacted', 'Converted' => 'Converted', 'Closed' => 'Closed'];
                DB::table('leads')->insertOrIgnore([
                    'lead_id'             => 'LEA-' . strtoupper(substr($row->submission_id ?? uniqid(), -8)),
                    'source'              => 'website',
                    'name'                => $row->name,
                    'email'               => $row->email,
                    'phone'               => $row->phone,
                    'company'             => $row->company,
                    'services_interested' => $row->service_interest,
                    'message'             => $row->message,
                    'status'              => $statusMap[$row->status] ?? 'New',
                    'priority'            => 'Normal',
                    'admin_notes'         => $row->admin_notes,
                    'contacted_at'        => $row->contacted_at,
                    'converted_client_id' => $row->converted_client_id,
                    'ip_address'          => $row->ip_address,
                    'original_ref'        => $row->submission_id,
                    'created_at'          => $row->created_at,
                    'updated_at'          => $row->updated_at,
                ]);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
