<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // who should see it
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // e.g. heroicon name
            $table->string('link')->nullable();
            $table->string('type')->default('info'); // info, success, warning, danger
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action'); // created, updated, deleted, sent, paid
            $table->string('entity_type'); // Quote, Invoice, Job, Client
            $table->string('entity_id')->nullable();
            $table->text('description')->nullable();
            $table->json('meta')->nullable(); // any extra context
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('notifications');
    }
};

