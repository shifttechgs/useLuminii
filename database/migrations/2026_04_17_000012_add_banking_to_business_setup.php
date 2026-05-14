<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_setup', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('quote_footer_notes');
            $table->string('bank_account_name')->nullable()->after('bank_name');
            $table->string('bank_account_number')->nullable()->after('bank_account_name');
            $table->string('bank_branch_code')->nullable()->after('bank_account_number');
            $table->string('bank_account_type')->nullable()->after('bank_branch_code'); // cheque, savings
            $table->string('swift_code')->nullable()->after('bank_account_type');
            $table->text('payment_instructions')->nullable()->after('swift_code');
            $table->string('default_tax_rate')->default('15')->after('payment_instructions');
            $table->string('invoice_prefix')->default('INV')->after('default_tax_rate');
            $table->string('quote_prefix')->default('QUO')->after('invoice_prefix');
        });
    }

    public function down(): void
    {
        Schema::table('business_setup', function (Blueprint $table) {
            $table->dropColumn([
                'bank_name','bank_account_name','bank_account_number',
                'bank_branch_code','bank_account_type','swift_code',
                'payment_instructions','default_tax_rate','invoice_prefix','quote_prefix',
            ]);
        });
    }
};

