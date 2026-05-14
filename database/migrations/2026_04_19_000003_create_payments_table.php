<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::defaultStringLength(191);

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id', 30)->unique();
            $table->string('invoice_id', 30)->nullable()->index();
            $table->string('quote_id', 30)->nullable()->index();
            $table->string('client_id', 30)->index();
            $table->decimal('amount', 10, 2);
            $table->string('type', 30)->default('payment'); // deposit, partial, full
            $table->string('method', 30)->default('eft');   // eft, cash, card, paypal
            $table->string('reference', 191)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('received_at');
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
