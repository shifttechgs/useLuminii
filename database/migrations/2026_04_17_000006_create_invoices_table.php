<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->string('business_id')->nullable();
            $table->string('job_id')->nullable();
            $table->string('client_id');
            $table->unsignedBigInteger('sales_person_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('invoice_date')->useCurrent();
            $table->timestamp('due_date')->nullable();
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('deposit_paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('payment_due', 10, 2)->default(0);
            $table->text('internal_notes')->nullable();
            $table->text('client_message')->nullable();
            $table->string('status')->default('Draft'); // Draft, Sent, Paid, PartiallyPaid, Overdue, Cancelled
            $table->string('payment_method')->nullable(); // cash, eft, card
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('view_token')->nullable(); // for client hub
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('recurring_invoice_id')->unique();
            $table->string('business_id')->nullable();
            $table->string('client_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('job_title');
            $table->text('description')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('recurrence_type'); // monthly, weekly, yearly
            $table->timestamp('start_date')->nullable();
            $table->timestamp('next_invoice_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('recurring_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('recurring_invoice_id');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_invoice_items');
        Schema::dropIfExists('recurring_invoices');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};

