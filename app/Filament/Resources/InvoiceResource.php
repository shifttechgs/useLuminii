<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\Job;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon  = 'heroicon-o-receipt-percent';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $recordTitleAttribute = 'invoice_id';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Overdue')->count() ?: null;
    }
    public static function getNavigationBadgeColor(): ?string { return 'danger'; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Invoice Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('invoice_id')->label('Invoice #')->disabled()->hiddenOn('create'),
                    Forms\Components\Select::make('invoice_type')
                        ->label('Invoice Type')
                        ->options([
                            'project'      => 'Project / Job',
                            'hosting'      => 'Hosting',
                            'consultation' => 'Consultation',
                            'domain'       => 'Domain Registration',
                            'maintenance'  => 'Maintenance',
                            'other'        => 'Other',
                        ])
                        ->default('project')
                        ->required()
                        ->live(),
                    Forms\Components\Select::make('client_id')->label('Client')->required()
                        ->options(BusinessClient::orderBy('company')->orderBy('firstname')->get()->mapWithKeys(fn ($c) => [$c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"]))
                        ->searchable(),
                    Forms\Components\Select::make('job_id')->label('Linked Job')
                        ->options(Job::pluck('job_title', 'job_id'))
                        ->searchable()
                        ->nullable()
                        ->hidden(fn (Get $get) => $get('invoice_type') !== 'project')
                        ->live()
                        ->afterStateUpdated(function (?string $state, Set $set) {
                            if (!$state) return;
                            $job = Job::with('items', 'quote')->where('job_id', $state)->first();
                            if (!$job) return;

                            $set('client_id', $job->client_id);

                            $depositPaid = 0;
                            if ($job->quote && $job->quote->deposit_received && $job->quote->required_deposit > 0) {
                                $depositPaid = $job->quote->required_deposit;
                            }
                            $set('deposit_paid', $depositPaid);

                            $set('items', $job->items->map(fn ($item) => [
                                'service_id'  => $item->service_id ?? null,
                                'description' => $item->description,
                                'quantity'    => $item->quantity,
                                'unit_price'  => $item->unit_price,
                                'line_total'  => $item->line_total,
                                'sort_order'  => $item->sort_order ?? 0,
                            ])->toArray());
                        }),
                    Forms\Components\Select::make('sales_person_id')->label('Sales Person')
                        ->options(User::whereIn('role',['Admin','SalesRep','SuperAdmin'])->pluck('name','id'))->default(auth()->id())->searchable(),
                    Forms\Components\Select::make('status')
                        ->options(['Draft'=>'Draft','Sent'=>'Sent','Paid'=>'Paid','PartiallyPaid'=>'Partially Paid','Overdue'=>'Overdue','Cancelled'=>'Cancelled'])
                        ->default('Draft')->required(),
                    Forms\Components\DatePicker::make('invoice_date')
                        ->label('Invoice Date')
                        ->default(today())
                        ->required(),
                    Forms\Components\DatePicker::make('due_date')->label('Due Date'),
                    Forms\Components\TextInput::make('deposit_paid')
                        ->label('Deposit Paid')
                        ->numeric()->default(0)->prefix(\App\Models\BusinessSetup::currencySymbol())
                        ->live(onBlur: true),
                ]),

            Forms\Components\Section::make('Line Items')
                ->headerActions([
                    Forms\Components\Actions\Action::make('import_from_job')
                        ->label('Import from Job')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('gray')
                        ->visible(fn (Get $get) => filled($get('job_id')))
                        ->requiresConfirmation()
                        ->modalHeading('Import Job Items')
                        ->modalDescription('This will replace the current line items with items from the linked job.')
                        ->action(function (Get $get, Set $set) {
                            $job = Job::with('items')->where('job_id', $get('job_id'))->first();
                            if (!$job) return;
                            $set('items', $job->items->map(fn ($item) => [
                                'service_id'  => null,
                                'description' => $item->description,
                                'quantity'    => $item->quantity,
                                'unit_price'  => $item->unit_price,
                                'line_total'  => $item->line_total,
                                'sort_order'  => $item->sort_order ?? 0,
                            ])->toArray());
                        }),
                ])
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->schema([
                            // Service select IS the description — picking auto-fills price and saves name to description
                            Forms\Components\Select::make('service_id')
                                ->label('Service / Description')
                                ->placeholder('Search service...')
                                ->options(
                                    BusinessService::where('is_active', true)
                                        ->orderBy('category')->orderBy('name')
                                        ->get()
                                        ->groupBy('category')
                                        ->map(fn ($g) => $g->pluck('name', 'service_id'))
                                        ->toArray()
                                )
                                ->searchable()
                                ->nullable()
                                ->live()
                                ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                    if ($state) {
                                        $svc = BusinessService::where('service_id', $state)->first();
                                        if ($svc) {
                                            $set('description', $svc->name);
                                            $set('unit_price', $svc->unit_price);
                                            $qty = (float) ($get('quantity') ?: 1);
                                            $set('line_total', round($qty * $svc->unit_price, 2));
                                        }
                                    } else {
                                        $set('description', null);
                                    }
                                })
                                ->hidden(fn (Get $get) => filled($get('description')) && !filled($get('service_id')))
                                ->columnSpan(6),

                            // Custom description — only visible when no service is selected
                            Forms\Components\TextInput::make('description')
                                ->label('Custom Description')
                                ->placeholder('Describe this item...')
                                ->hidden(fn (Get $get) => filled($get('service_id')))
                                ->required(fn (Get $get) => !filled($get('service_id')))
                                ->dehydrated(true)
                                ->columnSpan(6),

                            Forms\Components\TextInput::make('quantity')
                                ->numeric()->default(1)->minValue(1)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                    $set('line_total', round(((float) $state ?: 0) * ((float) $get('unit_price') ?: 0), 2));
                                })
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('unit_price')
                                ->label('Unit Price')->numeric()->default(0)->prefix(\App\Models\BusinessSetup::currencySymbol())
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                    $set('line_total', round(((float) $get('quantity') ?: 1) * ((float) $state ?: 0), 2));
                                })
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('line_total')
                                ->label('Total')->numeric()->disabled()->dehydrated(false)->prefix(\App\Models\BusinessSetup::currencySymbol())
                                ->columnSpan(2),
                        ])
                        ->columns(12)
                        ->addActionLabel('+ Add Line Item')
                        ->reorderable('sort_order')
                        ->defaultItems(1)
                        ->live(),
                ]),

            Forms\Components\Section::make('Totals')
                ->columns(3)
                ->schema([
                    Forms\Components\Placeholder::make('sub_total_display')
                        ->label('Subtotal')
                        ->content(function (Get $get): \Illuminate\Support\HtmlString {
                            $subtotal = collect($get('items') ?? [])
                                ->sum(fn ($i) => (float) ($i['quantity'] ?? 1) * (float) ($i['unit_price'] ?? 0));
                            return new \Illuminate\Support\HtmlString(
                                '<span class="text-lg font-semibold text-gray-800 dark:text-gray-200">R&nbsp;' . number_format($subtotal, 2) . '</span>'
                            );
                        }),

                    Forms\Components\TextInput::make('discount')
                        ->label('Discount')->numeric()->default(0)->prefix(\App\Models\BusinessSetup::currencySymbol())
                        ->live(onBlur: true),

                    Forms\Components\Placeholder::make('grand_total_display')
                        ->label('Invoice Total')
                        ->content(function (Get $get): \Illuminate\Support\HtmlString {
                            $subtotal = collect($get('items') ?? [])
                                ->sum(fn ($i) => (float) ($i['quantity'] ?? 1) * (float) ($i['unit_price'] ?? 0));
                            $total = max(0, $subtotal - (float) ($get('discount') ?? 0));
                            return new \Illuminate\Support\HtmlString(
                                '<span class="text-xl font-bold text-primary-600 dark:text-primary-400">R&nbsp;' . number_format($total, 2) . '</span>'
                            );
                        }),

                    Forms\Components\Placeholder::make('deposit_display')
                        ->label('Deposit Paid')
                        ->content(function (Get $get): \Illuminate\Support\HtmlString {
                            $deposit = (float) ($get('deposit_paid') ?? 0);
                            $color = $deposit > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400';
                            return new \Illuminate\Support\HtmlString(
                                "<span class=\"text-lg font-semibold {$color}\">R&nbsp;" . number_format($deposit, 2) . '</span>'
                            );
                        }),

                    Forms\Components\Placeholder::make('balance_display')
                        ->label('Balance Due')
                        ->content(function (Get $get): \Illuminate\Support\HtmlString {
                            $subtotal = collect($get('items') ?? [])
                                ->sum(fn ($i) => (float) ($i['quantity'] ?? 1) * (float) ($i['unit_price'] ?? 0));
                            $total   = max(0, $subtotal - (float) ($get('discount') ?? 0));
                            $balance = max(0, $total - (float) ($get('deposit_paid') ?? 0));
                            $color   = $balance <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400';
                            return new \Illuminate\Support\HtmlString(
                                "<span class=\"text-xl font-bold {$color}\">R&nbsp;" . number_format($balance, 2) . '</span>'
                            );
                        }),
                ]),

            Forms\Components\Section::make('Payment Details')
                ->columns(3)
                ->collapsed()
                ->schema([
                    Forms\Components\Select::make('payment_method')
                        ->options(['cash'=>'Cash','eft'=>'EFT','card'=>'Card','paypal'=>'PayPal','other'=>'Other'])->nullable(),
                    Forms\Components\TextInput::make('payment_reference')->label('Payment Reference')->nullable(),
                    Forms\Components\DatePicker::make('paid_at')->label('Payment Date')->nullable(),
                ]),

            Forms\Components\Section::make('Recurring Schedule')
                ->icon('heroicon-o-arrow-path')
                ->collapsed()
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_recurring')
                        ->label('Make this invoice recurring')
                        ->helperText('A recurring template will be created automatically — invoices will be generated and emailed on schedule.')
                        ->live()
                        ->columnSpanFull()
                        ->default(false),

                    Forms\Components\Select::make('recur_frequency')
                        ->label('Frequency')
                        ->options(['Weekly'=>'Weekly','Monthly'=>'Monthly','Quarterly'=>'Quarterly','Annually'=>'Annually'])
                        ->default('Monthly')
                        ->required()
                        ->visible(fn (Get $get) => $get('is_recurring')),

                    Forms\Components\DatePicker::make('recur_start_date')
                        ->label('Start Date')
                        ->default(today())
                        ->required()
                        ->visible(fn (Get $get) => $get('is_recurring')),

                    Forms\Components\DatePicker::make('recur_end_date')
                        ->label('End Date')
                        ->helperText('Leave blank for ongoing.')
                        ->nullable()
                        ->visible(fn (Get $get) => $get('is_recurring')),
                ])
                ->hiddenOn('edit'),

            Forms\Components\Section::make('Notes')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('internal_notes')->label('Internal Notes'),
                    Forms\Components\Textarea::make('client_message')->label('Message to Client'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_id')
                    ->label('Invoice #')->copyable()->sortable()->searchable()
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray'),
                Tables\Columns\TextColumn::make('client.firstname')->label('Client')
                    ->formatStateUsing(fn ($record) => optional($record->client)->full_name ?? '—')
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
                    ->description(fn ($record) => optional($record->client)->email),
                Tables\Columns\TextColumn::make('invoice_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'project'      => 'Project',
                        'hosting'      => 'Hosting',
                        'consultation' => 'Consultation',
                        'domain'       => 'Domain',
                        'maintenance'  => 'Maintenance',
                        'recurring'    => 'Recurring',
                        default        => 'Other',
                    })
                    ->color(fn ($state) => match($state) {
                        'project'      => 'primary',
                        'hosting'      => 'info',
                        'consultation' => 'warning',
                        'domain'       => 'success',
                        'maintenance'  => 'gray',
                        'recurring'    => 'purple',
                        default        => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'Draft'         => 'gray',
                        'Sent'          => 'info',
                        'Paid'          => 'success',
                        'PartiallyPaid' => 'warning',
                        'Overdue'       => 'danger',
                        'Cancelled'     => 'gray',
                        default         => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_amount')->label('Total')->money(\App\Models\BusinessSetup::current()->currency)->sortable(),
                Tables\Columns\TextColumn::make('balance')->label('Balance')->money(\App\Models\BusinessSetup::current()->currency)->sortable(),
                Tables\Columns\TextColumn::make('due_date')->label('Due')->date()->sortable()
                    ->color(fn ($record) => $record?->isOverdue() ? 'danger' : null),
            ])
            ->filters([
                SelectFilter::make('status')->options(['Draft'=>'Draft','Sent'=>'Sent','Paid'=>'Paid','PartiallyPaid'=>'Partially Paid','Overdue'=>'Overdue']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('send')
                        ->label('Send Invoice')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->visible(fn ($record) => $record->status === 'Draft' && $record->client?->email)
                        ->modalHeading(false)
                        ->modalContent(fn ($record) => view('filament.modals.invoice-send-preview', ['invoice' => $record->load('items')]))
                        ->modalWidth('2xl')
                        ->modalSubmitActionLabel('Confirm — Send Now')
                        ->action(function ($record) {
                            $record->update(['status' => 'Sent']);
                            \Illuminate\Support\Facades\Mail::to($record->client->email)
                                ->send(new \App\Mail\InvoiceMail($record));
                            \App\Models\ActivityLog::record('sent', 'Invoice', $record->invoice_id, "Invoice {$record->invoice_id} sent to {$record->client->email}");
                            \Filament\Notifications\Notification::make()
                                ->title("Invoice sent to {$record->client->email}")
                                ->success()->send();
                        }),

                    Tables\Actions\Action::make('send_reminder')
                        ->label('Send Reminder')
                        ->icon('heroicon-o-bell-alert')
                        ->color('warning')
                        ->visible(fn ($record) => in_array($record->status, ['Sent', 'Overdue']) && $record->client?->email)
                        ->modalHeading(false)
                        ->modalContent(fn ($record) => view('filament.modals.invoice-send-preview', ['invoice' => $record->load('items')]))
                        ->modalWidth('2xl')
                        ->modalSubmitActionLabel('Confirm — Send Reminder')
                        ->action(function ($record) {
                            \Illuminate\Support\Facades\Mail::to($record->client->email)
                                ->send(new \App\Mail\InvoiceMail($record));
                            \App\Models\ActivityLog::record('sent', 'Invoice', $record->invoice_id, "Payment reminder sent to {$record->client->email}");
                            \Filament\Notifications\Notification::make()
                                ->title("Reminder sent to {$record->client->email}")
                                ->success()->send();
                        }),

                    Tables\Actions\Action::make('record_payment')
                        ->label('Record Payment')
                        ->icon('heroicon-o-banknotes')
                        ->color('success')
                        ->visible(fn ($record) => !in_array($record->status, ['Paid', 'Cancelled']))
                        ->form([
                            Forms\Components\TextInput::make('amount')
                                ->label('Amount Received (R)')
                                ->numeric()
                                ->required()
                                ->default(fn ($record) => $record->balance > 0 ? $record->balance : $record->total_amount),
                            Forms\Components\Select::make('method')
                                ->options(['eft' => 'EFT', 'cash' => 'Cash', 'card' => 'Card', 'paypal' => 'PayPal'])
                                ->default('eft')
                                ->required(),
                            Forms\Components\TextInput::make('reference')
                                ->label('Reference / Receipt No.')
                                ->nullable(),
                            Forms\Components\DatePicker::make('received_at')
                                ->label('Date Received')
                                ->default(now())
                                ->required(),
                            Forms\Components\Textarea::make('notes')
                                ->rows(2)
                                ->nullable(),
                        ])
                        ->action(function ($record, array $data) {
                            \App\Models\Payment::create([
                                'invoice_id'  => $record->invoice_id,
                                'client_id'   => $record->client_id,
                                'amount'      => $data['amount'],
                                'type'        => 'payment',
                                'method'      => $data['method'],
                                'reference'   => $data['reference'],
                                'notes'       => $data['notes'],
                                'received_at' => $data['received_at'],
                                'recorded_by' => auth()->id(),
                            ]);
                            $record->recalculateBalance();
                            \App\Models\ActivityLog::record('updated', 'Invoice', $record->invoice_id,
                                "Payment of R " . number_format($data['amount'], 2) . " recorded via {$data['method']}");
                            \Filament\Notifications\Notification::make()
                                ->title('Payment recorded')
                                ->body('Invoice balance updated.')
                                ->success()->send();
                        }),

                    Tables\Actions\Action::make('download_pdf')
                        ->label('Download PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('gray')
                        ->url(fn ($record) => route('invoice.pdf', $record->invoice_id))
                        ->openUrlInNewTab(),

                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('More'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('created_at','desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view'   => Pages\ViewInvoice::route('/{record}'),
            'edit'   => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}




