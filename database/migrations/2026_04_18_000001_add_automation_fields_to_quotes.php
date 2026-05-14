<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::defaultStringLength(191);

        Schema::table('quotes', function (Blueprint $table) {
            $table->string('request_id', 30)->nullable()->after('client_id');
        });

        Schema::table('quote_items', function (Blueprint $table) {
            $table->string('service_id', 30)->nullable()->after('quote_id');
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('request_id');
        });

        Schema::table('quote_items', function (Blueprint $table) {
            $table->dropColumn('service_id');
        });
    }
};
