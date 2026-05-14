<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::defaultStringLength(191);

        Schema::create('job_status_logs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id', 30)->index();
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->text('note')->nullable();
            $table->boolean('client_notified')->default(false);
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_status_logs');
    }
};
