<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('recurring_invoices')) {
            return;
        }

        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('recurring_invoice_id')->unique();
            $table->string('business_id')->nullable();
            $table->string('client_id');
            $table->string('job_id')->nullable();
            $table->string('frequency'); // Weekly, Monthly, Quarterly, Annually
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->nullable();
            $table->decimal('deposit_paid', 10, 2)->nullable();
            $table->decimal('payment_due', 10, 2)->nullable();
            $table->string('status')->default('Active'); // Active, Paused, Cancelled, Completed
            $table->text('internal_notes')->nullable();
            $table->text('client_message')->nullable();
            $table->string('created_by')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('next_invoice_date')->nullable();
            $table->integer('invoices_generated')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('recurring_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recurring_invoice_id');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('recurring_invoice_id')
                  ->references('id')
                  ->on('recurring_invoices')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_invoice_items');
        Schema::dropIfExists('recurring_invoices');
    }
};


