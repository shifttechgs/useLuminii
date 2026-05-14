<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('Admin')->after('email'); // SuperAdmin, Admin, SalesRep, Technician
            $table->string('phone')->nullable()->after('role');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('business_id')->nullable()->after('avatar');
            $table->boolean('is_active')->default(true)->after('business_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'avatar', 'business_id', 'is_active', 'last_login_at']);
        });
    }
};

