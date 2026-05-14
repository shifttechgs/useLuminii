<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add services_interested to client_requests
        Schema::table('client_requests', function (Blueprint $table) {
            $table->string('service_id', 20)->nullable()->after('title');
        });

        // 2. Replace/sync business_services to match website + CRM needs
        $services = [
            ['name' => 'Web Design & Development',  'category' => 'Development',     'unit_type' => 'job'],
            ['name' => 'Mobile App Development',     'category' => 'Development',     'unit_type' => 'job'],
            ['name' => 'Custom Software',            'category' => 'Development',     'unit_type' => 'job'],
            ['name' => 'MVP Development',            'category' => 'Development',     'unit_type' => 'job'],
            ['name' => 'UI/UX Design',               'category' => 'Design',          'unit_type' => 'job'],
            ['name' => 'AI & Automation',            'category' => 'Development',     'unit_type' => 'job'],
            ['name' => 'Cloud & DevOps',             'category' => 'Infrastructure',  'unit_type' => 'job'],
            ['name' => 'IT Consulting',              'category' => 'Consulting',      'unit_type' => 'hour'],
            ['name' => 'Monthly Maintenance',        'category' => 'Support',         'unit_type' => 'month'],
        ];

        // Soft-delete old records and insert canonical set
        DB::table('business_services')->update(['deleted_at' => now()]);

        foreach ($services as $svc) {
            $exists = DB::table('business_services')
                ->where('name', $svc['name'])
                ->first();

            if ($exists) {
                DB::table('business_services')
                    ->where('name', $svc['name'])
                    ->update(['deleted_at' => null, 'is_active' => true, 'category' => $svc['category'], 'unit_type' => $svc['unit_type']]);
            } else {
                DB::table('business_services')->insert([
                    'service_id'  => 'SVC-' . strtoupper(substr(uniqid(), -6)),
                    'name'        => $svc['name'],
                    'category'    => $svc['category'],
                    'unit_type'   => $svc['unit_type'],
                    'unit_price'  => 0,
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('client_requests', function (Blueprint $table) {
            $table->dropColumn('service_id');
        });
    }
};
