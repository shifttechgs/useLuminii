<?php

namespace App\Filament\Pages;

use App\Models\BusinessSetup;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class BusinessSettings extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Business Settings';
    protected static ?string $title           = 'Business Settings';
    protected static ?int    $navigationSort  = 0;
    protected static string  $view            = 'filament.pages.business-settings';

    public array $data = [];

    public function mount(): void
    {
        $setup = BusinessSetup::current();
        $this->form->fill($setup->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                // ── Identity ────────────────────────────────────────────────
                Forms\Components\Section::make('Business Identity')
                    ->icon('heroicon-o-building-office')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('business_name')
                            ->label('Business Name')->required()->columnSpanFull(),
                        Forms\Components\TextInput::make('email')->email()->label('Business Email'),
                        Forms\Components\TextInput::make('phone')->tel()->label('Phone Number'),
                        Forms\Components\TextInput::make('website')->url()->label('Website')->placeholder('https://'),
                        Forms\Components\TextInput::make('vat_number')->label('VAT Number')->placeholder('VAT4XXXXXXX'),
                        Forms\Components\TextInput::make('registration_number')->label('Company Registration No.'),
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Company Logo')
                            ->image()
                            ->directory('business')
                            ->imageResizeMode('contain')
                            ->imageCropAspectRatio('4:1')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('200')
                            ->columnSpanFull(),
                    ]),

                // ── Address ─────────────────────────────────────────────────
                Forms\Components\Section::make('Business Address')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('street')->label('Street Address')->columnSpanFull(),
                        Forms\Components\TextInput::make('city')->label('City'),
                        Forms\Components\TextInput::make('province')->label('Province / State'),
                        Forms\Components\TextInput::make('postal_code')->label('Postal Code'),
                        Forms\Components\TextInput::make('country')->label('Country')->default('South Africa'),
                    ]),

                // ── Banking ─────────────────────────────────────────────────
                Forms\Components\Section::make('Banking Details')
                    ->icon('heroicon-o-banknotes')
                    ->description('These details appear on invoices for EFT payments.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')->label('Bank Name')->placeholder('FNB, ABSA, Standard Bank…'),
                        Forms\Components\TextInput::make('bank_account_name')->label('Account Name'),
                        Forms\Components\TextInput::make('bank_account_number')->label('Account Number'),
                        Forms\Components\TextInput::make('bank_branch_code')->label('Branch Code'),
                        Forms\Components\Select::make('bank_account_type')
                            ->label('Account Type')
                            ->options(['cheque' => 'Cheque / Current', 'savings' => 'Savings', 'transmission' => 'Transmission']),
                        Forms\Components\TextInput::make('swift_code')->label('SWIFT Code')->placeholder('For international payments'),
                        Forms\Components\Textarea::make('payment_instructions')
                            ->label('Payment Instructions')
                            ->placeholder('e.g. Use invoice number as reference. Payment due within 7 days.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                // ── Invoice & Quote Settings ─────────────────────────────────
                Forms\Components\Section::make('Invoice & Quote Settings')
                    ->icon('heroicon-o-document-text')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('invoice_prefix')->label('Invoice Number Prefix')->default('INV'),
                        Forms\Components\TextInput::make('quote_prefix')->label('Quote Number Prefix')->default('QUO'),
                        Forms\Components\TextInput::make('default_tax_rate')
                            ->label('Default Tax Rate (%) — set to 0 if not VAT registered')
                            ->numeric()
                            ->default('0')
                            ->suffix('%')
                            ->helperText('ShiftTech is not yet VAT registered. Keep this at 0 until SARS registration is complete.'),
                        Forms\Components\Select::make('currency')
                            ->label('Currency')
                            ->options(['ZAR' => 'ZAR – South African Rand', 'USD' => 'USD – US Dollar', 'EUR' => 'EUR – Euro', 'GBP' => 'GBP – British Pound'])
                            ->default('ZAR'),
                        Forms\Components\Textarea::make('invoice_footer_notes')
                            ->label('Invoice Footer Notes')
                            ->placeholder('e.g. Thank you for your business! Payment is due within 7 days.')
                            ->rows(3),
                        Forms\Components\Textarea::make('quote_footer_notes')
                            ->label('Quote Footer Notes')
                            ->placeholder('e.g. This quote is valid for 30 days from the date issued.')
                            ->rows(3),
                    ]),

                // ── Working Hours ────────────────────────────────────────────
                Forms\Components\Section::make('Working Hours')
                    ->icon('heroicon-o-clock')
                    ->columns(1)
                    ->collapsed()
                    ->schema([
                        Forms\Components\Repeater::make('working_hours')
                            ->label(false)
                            ->schema([
                                Forms\Components\Select::make('day')
                                    ->options([
                                        'Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday',
                                        'Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday','Sunday'=>'Sunday',
                                    ])->required()->columnSpan(2),
                                Forms\Components\TimePicker::make('open_time')->label('Opens')->seconds(false)->columnSpan(2),
                                Forms\Components\TimePicker::make('close_time')->label('Closes')->seconds(false)->columnSpan(2),
                                Forms\Components\Toggle::make('is_closed')->label('Closed')->columnSpan(1),
                            ])
                            ->columns(7)
                            ->addActionLabel('+ Add Day')
                            ->defaultItems(0),
                    ]),

                // ── Timezone ─────────────────────────────────────────────────
                Forms\Components\Section::make('Regional Settings')
                    ->icon('heroicon-o-globe-alt')
                    ->columns(1)
                    ->collapsed()
                    ->schema([
                        Forms\Components\Select::make('timezone')
                            ->label('Timezone')
                            ->searchable()
                            ->options(collect(timezone_identifiers_list())->mapWithKeys(fn ($tz) => [$tz => $tz]))
                            ->default('Africa/Johannesburg'),
                    ]),

            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->icon('heroicon-o-check-circle')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $setup = BusinessSetup::current();
        $setup->update($data);

        Notification::make()
            ->title('Business settings saved successfully!')
            ->success()
            ->send();
    }
}


