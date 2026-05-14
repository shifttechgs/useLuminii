<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::defaultStringLength(191);

        Schema::table('quotes', function (Blueprint $table) {
            $table->string('currency', 3)->default('ZAR')->after('status');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('currency', 3)->default('ZAR')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('quotes',   fn (Blueprint $t) => $t->dropColumn('currency'));
        Schema::table('invoices', fn (Blueprint $t) => $t->dropColumn('currency'));
    }
};
