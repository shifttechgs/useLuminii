<?php

namespace App\Console\Commands;

use App\Actions\CreateBusiness as CreateBusinessAction;
use App\Models\User;
use Illuminate\Console\Command;

/**
 * Set up a new, separate business by hand (complimentary: never charged): its settings,
 * default expense categories, an owner who can sign in to the CRM, and its subscription.
 * The owner's password comes from LUMINII_OWNER_PASSWORD so it never appears in the
 * command line or shell history. Self-serve sign-up uses the same App\Actions\CreateBusiness.
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

        $name = trim($this->argument('name'));

        $result = (new CreateBusinessAction())->handle([
            'name'        => $name,
            'owner_name'  => $this->option('owner-name') ?: $name,
            'owner_email' => $email,
            'password'    => $password,
            'currency'    => $currency,
            'timezone'    => $this->option('timezone'),
        ]);
        $businessId = $result['business_id'];

        $this->info("Created {$name} ({$businessId}).");
        $this->line("Owner {$email} can sign in at " . url('/useluminii') . '.');

        return self::SUCCESS;
    }
}
