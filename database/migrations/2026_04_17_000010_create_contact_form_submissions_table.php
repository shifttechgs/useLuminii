<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('submission_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('service_interest')->nullable();
            $table->string('lead_source')->default('website'); // website, referral, social
            $table->string('status')->default('New'); // New, Contacted, Converted, Closed
            $table->unsignedBigInteger('converted_client_id')->nullable(); // set when converted to client
            $table->text('admin_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('email_sent_to_admin')->default(false);
            $table->boolean('email_sent_to_client')->default(false);
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_form_submissions');
    }
};

