<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop Stripe columns if they exist
            if (Schema::hasColumn('invoices', 'stripe_payment_intent_id')) {
                $table->dropColumn('stripe_payment_intent_id');
            }
            if (Schema::hasColumn('invoices', 'stripe_checkout_url')) {
                $table->dropColumn('stripe_checkout_url');
            }
            // Add PayPal columns
            if (! Schema::hasColumn('invoices', 'paypal_order_id')) {
                $table->string('paypal_order_id')->nullable()->after('paid_at');
            }
            if (! Schema::hasColumn('invoices', 'paypal_capture_id')) {
                $table->string('paypal_capture_id')->nullable()->after('paypal_order_id');
            }
            if (! Schema::hasColumn('invoices', 'payment_method')) {
                $table->string('payment_method')->nullable()->default('EFT')->after('paypal_capture_id');
            }
        });
    }
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['paypal_order_id', 'paypal_capture_id', 'payment_method']);
        });
    }
};
