<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('invoices', 'stripe_payment_intent_id')) {
                $table->string('stripe_payment_intent_id')->nullable()->after('paid_at');
            }
            if (! Schema::hasColumn('invoices', 'stripe_checkout_url')) {
                $table->text('stripe_checkout_url')->nullable()->after('stripe_payment_intent_id');
            }
        });
    }
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['stripe_payment_intent_id', 'stripe_checkout_url']);
        });
    }
};
