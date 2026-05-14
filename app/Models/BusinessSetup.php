<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetup extends Model
{
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
    public static function current(): self
    {
        return static::firstOrCreate(
            ['business_id' => 'ST-001'],
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


