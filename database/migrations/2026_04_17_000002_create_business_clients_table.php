<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->unique();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // assigned sales rep
            $table->string('firstname');
            $table->string('lastname');
            $table->string('company')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('South Africa');
            $table->string('lead_source')->nullable(); // website, referral, walk-in etc
            $table->string('client_type')->default('Lead'); // Lead, Prospect, Client
            $table->string('status')->default('Active'); // Active, Inactive
            $table->string('source')->nullable(); // lead, customer
            $table->string('communication_preference')->default('email'); // phone, email, whatsapp
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_clients');
    }
};

