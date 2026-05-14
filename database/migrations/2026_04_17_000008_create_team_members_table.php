<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->unique(); // FK to users
            $table->string('role')->default('Technician'); // Admin, SalesRep, Technician
            $table->string('job_title')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
        });

        Schema::create('client_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->string('business_id')->nullable();
            $table->string('client_id');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('New'); // New, InReview, Quoted, Closed
            $table->string('priority')->default('Normal'); // Low, Normal, High, Urgent
            $table->text('assessment_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_requests');
        Schema::dropIfExists('team_members');
    }
};

