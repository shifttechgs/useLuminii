<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetup extends Model
{
    use \App\Models\Concerns\BelongsToBusiness;

    protected $table = 'business_setup';

    protected $fillable = [
        'business_id', 'business_name', 'email', 'phone', 'website', 'logo_path',
        'street', 'city', 'province', 'postal_code', 'country',
        'vat_number', 'registration_number', 'currency', 'timezone',
        'invoice_footer_notes', 'quote_footer_notes', 'working_hours',
        'bank_name', 'bank_account_name', 'bank_account_number',
        'bank_branch_code', 'bank_account_type', 'swift_code',
        'payment_instructions', 'default_tax_rate', 'invoice_prefix', 'quote_prefix',
    ];

    protected $casts = [
        'working_hours' => 'array',
    ];

    /**
     * Always return the single business record, creating it if missing.
     */
    /**
     * The current business's settings (see App\Support\CurrentBusiness), created on first use.
     * Only the platform business starts with ShiftTech's details; any other business starts
     * blank, so one business's name or bank details can never appear on another's documents.
     */
    public static function current(): self
    {
        $businessId = \App\Support\CurrentBusiness::idOrPlatform();

        if ($businessId === \App\Support\CurrentBusiness::NONE) {
            return new static(['business_name' => '']);   // signed in without a business: nothing to show
        }

        if ($businessId !== \App\Support\CurrentBusiness::platform()) {
            return static::firstOrCreate(['business_id' => $businessId], [
                'business_name'    => 'My business',
                'currency'         => 'ZAR',
                'timezone'         => config('app.timezone', 'UTC'),
                'default_tax_rate' => '0',
                'invoice_prefix'   => 'INV',
                'quote_prefix'     => 'QUO',
            ]);
        }

        return static::firstOrCreate(
            ['business_id' => $businessId],
            [
                'business_name'   => 'ShiftTech Global Solutions',
                'email'           => 'sales@shifttechgs.com',
                'phone'           => '',
                'website'         => 'https://shifttechgs.com',
                'country'         => 'South Africa',
                'currency'        => 'ZAR',
                'timezone'        => 'Africa/Johannesburg',
                'default_tax_rate'=> '0',
                'invoice_prefix'  => 'INV',
                'quote_prefix'    => 'QUO',
                'bank_name'       => 'FNB',
                'bank_account_name' => 'ShiftTech General Solutions',
                'bank_branch_code'  => '250655',
            ]
        );
    }

    public static function currencySymbol(?string $currency = null): string
    {
        $code = $currency ?? static::current()->currency;
        return match($code) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => 'R',
        };
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path
            ? asset('storage/' . $this->logo_path)
            : null;
    }

    public function getFormattedAddressAttribute(): string
    {
        return collect([$this->street, $this->city, $this->province, $this->postal_code, $this->country])
            ->filter()
            ->implode(', ');
    }
}


