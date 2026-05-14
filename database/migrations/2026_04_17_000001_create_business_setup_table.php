<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_setup', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->unique();
            $table->string('business_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('South Africa');
            $table->string('vat_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('currency')->default('ZAR');
            $table->string('timezone')->default('Africa/Johannesburg');
            $table->text('invoice_footer_notes')->nullable();
            $table->text('quote_footer_notes')->nullable();
            $table->json('working_hours')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_setup');
    }
};

