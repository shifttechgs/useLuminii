<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->string('name');
            $table->string('color')->default('#6366f1');
            $table->integer('sort_order')->default(99);
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_id')->unique();
            $table->string('business_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('description');
            $table->string('vendor')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamp('expense_date')->useCurrent();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_type')->nullable(); // monthly, weekly, yearly
            $table->text('notes')->nullable();
            $table->string('receipt_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};


