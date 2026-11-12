<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BusinessService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin. The password comes from SEED_ADMIN_PASSWORD; without it a random one is set
        // (reset it from the login page). Never hardcode it here: this repo is shared.
        $password = env('SEED_ADMIN_PASSWORD') ?: Str::password(24);
        User::firstOrCreate(
            ['email' => 'admin@shifttechgs.com'],
            [
                'name'        => 'ShiftTech Admin',
                'password'    => Hash::make($password),
                'role'        => 'SuperAdmin',
                'is_active'   => true,
                'business_id' => 'ST-001',
            ]
        );

        // Expense Categories (12 default)
        $this->call(ExpenseCategorySeeder::class);

        // Default Business Services
        foreach ([
            ['name' => 'Web Design',                 'category' => 'Development',    'unit_price' => 5000,  'unit_type' => 'project'],
            ['name' => 'Web Application Development','category' => 'Development',    'unit_price' => 15000, 'unit_type' => 'project'],
            ['name' => 'Mobile App Development',     'category' => 'Development',    'unit_price' => 20000, 'unit_type' => 'project'],
            ['name' => 'Custom Software',            'category' => 'Development',    'unit_price' => 25000, 'unit_type' => 'project'],
            ['name' => 'DevOps / Cloud Setup',       'category' => 'Infrastructure', 'unit_price' => 8000,  'unit_type' => 'project'],
            ['name' => 'IT Consulting (Hourly)',      'category' => 'Consulting',     'unit_price' => 850,   'unit_type' => 'hour'],
            ['name' => 'Monthly Maintenance',        'category' => 'Support',        'unit_price' => 2500,  'unit_type' => 'month'],
        ] as $svc) {
            BusinessService::firstOrCreate(['name' => $svc['name']], array_merge($svc, ['is_active' => true, 'business_id' => 'ST-001']));
        }

        $this->command->info('✅  CRM seeded! Admin login: admin@shifttechgs.com (password from SEED_ADMIN_PASSWORD)');
        $this->command->info('    URL: /useluminii');
    }
}
