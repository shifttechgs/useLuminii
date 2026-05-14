<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecurringInvoiceResource\Pages;
use App\Models\RecurringInvoice;
use App\Models\BusinessClient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class RecurringInvoiceResource extends Resource
{
    protected static ?string $model = RecurringInvoice::class;
    protected static ?string $navigationIcon  = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Recurring Invoices';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Recurring Invoice Details')->columns(2)->schema([
                Forms\Components\Select::make('client_id')
                    ->label('Client')
                    ->options(BusinessClient::orderBy('company')->orderBy('firstname')->get()->mapWithKeys(fn ($c) =>
                        [$c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"]
                    ))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('frequency')
                    ->options([
                        'Weekly'    => 'Weekly',
                        'Monthly'   => 'Monthly',
                        'Quarterly' => 'Quarterly',
                        'Annually'  => 'Annually',
                    ])
                    ->required()
                    ->default('Monthly'),

                Forms\Components\DatePicker::make('start_date')->required()->default(now()),
                Forms\Components\DatePicker::make('end_date')->nullable()->label('End Date (leave blank for ongoing)'),

                Forms\Components\Select::make('status')
                    ->options([
                        'Active'    => 'Active',
                        'Paused'    => 'Paused',
                        'Cancelled' => 'Cancelled',
                        'Completed' => 'Completed',
                    ])
                    ->default('Active')
                    ->required(),

                Forms\Components\TextInput::make('total_amount')->label('Total Amount (R)')->numeric()->required(),
                Forms\Components\TextInput::make('deposit_paid')->label('Deposit Paid (R)')->numeric()->nullable(),
                Forms\Components\TextInput::make('payment_due')->label('Payment Due (R)')->numeric()->nullable(),
            ]),

            Forms\Components\Section::make('Line Items')->schema([
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('description')->required()->columnSpan(2),
                        Forms\Components\TextInput::make('quantity')->numeric()->default(1)->required(),
                        Forms\Components\TextInput::make('unit_price')->numeric()->required()->label('Unit Price (R)'),
                        Forms\Components\TextInput::make('total')->numeric()->required()->label('Line Total (R)'),
                    ])
                    ->columns(5)
                    ->defaultItems(1)
                    ->addActionLabel('Add Item')
                    ->reorderable(false),
            ]),

            Forms\Components\Section::make('Notes')->columns(1)->schema([
                Forms\Components\Textarea::make('client_message')->label('Message to Client')->nullable(),
                Forms\Components\Textarea::make('internal_notes')->label('Internal Notes')->nullable(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recurring_invoice_id')
                    ->label('ID')->copyable()->sortable()->searchable()
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('client.firstname')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => optional($record->client)->full_name ?? trim(optional($record->client)->firstname . ' ' . optional($record->client)->lastname) ?: '—')
                    ->weight(FontWeight::SemiBold)
                    ->description(fn ($record) => optional($record->client)->company ?: optional($record->client)->email)
                    ->searchable(),

                Tables\Columns\TextColumn::make('frequency')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Weekly'    => 'info',
                        'Monthly'   => 'primary',
                        'Quarterly' => 'warning',
                        'Annually'  => 'success',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Active'    => 'success',
                        'Paused'    => 'warning',
                        'Cancelled' => 'danger',
                        'Completed' => 'gray',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('total_amount')->label('Amount')->money(\App\Models\BusinessSetup::current()->currency)->sortable(),

                Tables\Columns\TextColumn::make('next_invoice_date')
                    ->label('Next Invoice')->date()->sortable()->placeholder('—'),

                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        return match (true) {
                            $record->status === 'Cancelled'                                                          => '— Cancelled',
                            $record->status === 'Completed'                                                          => '— Completed',
                            $record->status === 'Paused'                                                             => '▶ Resume or review',
                            $record->status === 'Active' && $record->next_invoice_date && \Carbon\Carbon::parse($record->next_invoice_date)->diffInDays(now(), false) >= 0 => '📤 Generate invoice',
                            $record->status === 'Active' && $record->next_invoice_date && \Carbon\Carbon::parse($record->next_invoice_date)->diffInDays() <= 3              => '📅 Invoice due soon',
                            $record->status === 'Active'                                                             => '✅ Running',
                            default                                                                                  => '—',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        str_contains($state, '📤')  => 'danger',
                        str_contains($state, '📅')  => 'warning',
                        str_contains($state, '▶')   => 'warning',
                        str_contains($state, '✅')  => 'success',
                        default                      => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('frequency')
                    ->options(['Weekly'=>'Weekly','Monthly'=>'Monthly','Quarterly'=>'Quarterly','Annually'=>'Annually']),
                SelectFilter::make('status')
                    ->options(['Active'=>'Active','Paused'=>'Paused','Cancelled'=>'Cancelled','Completed'=>'Completed']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('pause')
                        ->label('Pause Schedule')
                        ->icon('heroicon-o-pause-circle')
                        ->color('warning')
                        ->visible(fn (RecurringInvoice $r) => $r->status === 'Active')
                        ->requiresConfirmation()
                        ->action(fn (RecurringInvoice $r) => $r->update(['status' => 'Paused'])),

                    Tables\Actions\Action::make('activate')
                        ->label('Resume Schedule')
                        ->icon('heroicon-o-play-circle')
                        ->color('success')
                        ->visible(fn (RecurringInvoice $r) => $r->status === 'Paused')
                        ->requiresConfirmation()
                        ->action(fn (RecurringInvoice $r) => $r->update(['status' => 'Active'])),

                    Tables\Actions\DeleteAction::make(),
                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('More'),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRecurringInvoices::route('/'),
            'create' => Pages\CreateRecurringInvoice::route('/create'),
            'edit'   => Pages\EditRecurringInvoice::route('/{record}/edit'),
        ];
    }
}

