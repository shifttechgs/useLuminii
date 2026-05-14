<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->boolean('deposit_received')->default(false)->after('required_deposit');
            $table->timestamp('deposit_received_at')->nullable()->after('deposit_received');
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['deposit_received', 'deposit_received_at']);
        });
    }
};
