<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_id')->unique();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // sales rep
            $table->string('client_id');
            $table->string('job_title');
            $table->integer('opportunity_rating')->default(0); // 1-5
            $table->decimal('required_deposit', 10, 2)->default(0);
            $table->text('internal_notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->string('status')->default('Draft'); // Draft, Sent, Accepted, Declined, Expired
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('discount_type')->default('fixed'); // fixed, percentage
            $table->timestamp('quote_date')->useCurrent();
            $table->timestamp('expiry_date')->nullable();
            $table->string('accepted_token')->nullable(); // for client hub
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->string('quote_id');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0); // percentage e.g. 15
            $table->decimal('line_total', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
        Schema::dropIfExists('quotes');
    }
};

