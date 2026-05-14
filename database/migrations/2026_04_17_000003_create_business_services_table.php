<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_id')->unique();
            $table->string('business_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->string('unit_type')->default('hour'); // hour, day, item, job
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_services');
    }
};

