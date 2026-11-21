<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * One useLuminii subscription per business (plan, trial, billing state).
 *
 * Businesses that existed before self-serve sign-up (set up by hand, including the
 * platform business) get an active, complimentary subscription so nothing changes
 * for them and they are never charged automatically.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('business_id', 30)->unique();
            $table->string('plan', 20);                       // starter | business
            $table->string('interval', 10)->default('monthly'); // monthly | annual
            $table->string('status', 20);                     // trialing | active | past_due | read_only | cancelled
            $table->boolean('complimentary')->default(false); // set up by hand: never charged
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->unsignedInteger('extra_seats')->default(0);
            $table->boolean('cancel_at_period_end')->default(false);
            $table->json('pending_changes')->nullable();
            // Paystack (filled in once the business pays)
            $table->string('paystack_customer_code', 60)->nullable();
            $table->text('authorization_code')->nullable();   // encrypted
            $table->string('card_brand', 30)->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->string('card_exp', 7)->nullable();
            $table->timestamps();

            $table->index('status');
        });

        $now = now();
        $existing = DB::table('business_setup')->pluck('business_id')
            ->merge(DB::table('users')->whereNotNull('business_id')->distinct()->pluck('business_id'))
            ->filter()
            ->unique();

        foreach ($existing as $businessId) {
            DB::table('subscriptions')->insert([
                'business_id'   => $businessId,
                'plan'          => 'business',
                'interval'      => 'monthly',
                'status'        => 'active',
                'complimentary' => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
