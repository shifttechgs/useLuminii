<?php

namespace App\Console\Commands;

use App\Models\BusinessSetup;
use App\Models\User;
use App\Support\CurrentBusiness;
use Database\Seeders\ExpenseCategorySeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Set up a new, separate business: its settings, default expense categories and an owner
 * who can sign in to the CRM. The owner's password comes from LUMINII_OWNER_PASSWORD so it
 * never appears in the command line or shell history.
 *
 *   LUMINII_OWNER_PASSWORD=... php artisan crm:create-business "Acme Plumbing" owner@acme.example --owner-name="Sam Doe"
 */
class CreateBusiness extends Command
{
    protected $signature = 'crm:create-business
        {name : Business name}
        {owner_email : Email the owner signs in with}
        {--owner-name= : Owner\'s full name (defaults to the business name)}
        {--currency=ZAR : Default currency code}
        {--timezone= : Time zone (defaults to the app time zone)}';

    protected $description = 'Create a separate business with its own settings and an owner account';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('owner_email')));
        $password = (string) env('LUMINII_OWNER_PASSWORD', '');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('That owner email is not valid.');

            return self::FAILURE;
        }
        if (strlen($password) < 12) {
            $this->error('Set LUMINII_OWNER_PASSWORD (at least 12 characters) for this command only.');

            return self::FAILURE;
        }
        if (User::allBusinesses()->where('email', $email)->exists()) {
            $this->error('A user with that email already exists.');

            return self::FAILURE;
        }
        $currency = strtoupper((string) $this->option('currency'));
        if (! preg_match('/^[A-Z]{3}$/', $currency)) {
            $this->error('Currency must be a 3-letter code, for example ZAR or USD.');

            return self::FAILURE;
        }

        do {
            $businessId = 'BUS-' . strtoupper(Str::random(8));
        } while (BusinessSetup::allBusinesses()->where('business_id', $businessId)->exists());

        $name = trim($this->argument('name'));

        CurrentBusiness::run($businessId, function () use ($businessId, $name, $email, $password, $currency) {
            DB::transaction(function () use ($businessId, $name, $email, $password, $currency) {
                BusinessSetup::create([
                    'business_id'      => $businessId,
                    'business_name'    => $name,
                    'email'            => $email,
                    'currency'         => $currency,
                    'timezone'         => $this->option('timezone') ?: config('app.timezone', 'UTC'),
                    'default_tax_rate' => '0',
                    'invoice_prefix'   => 'INV',
                    'quote_prefix'     => 'QUO',
                ]);

                (new ExpenseCategorySeeder())->run($businessId);

                User::create([
                    'business_id' => $businessId,
                    'name'        => $this->option('owner-name') ?: $name,
                    'email'       => $email,
                    'password'    => Hash::make($password),
                    'role'        => 'Admin',
                    'is_active'   => true,
                ]);
            });
        });

        $this->info("Created {$name} ({$businessId}).");
        $this->line("Owner {$email} can sign in at " . url('/useluminii') . '.');

        return self::SUCCESS;
    }
}
