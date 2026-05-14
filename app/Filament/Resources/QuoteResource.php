<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteResource\Pages;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\ClientRequest;
use App\Models\Quote;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;
    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Operations';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $recordTitleAttribute = 'quote_id';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Draft')->count() ?: null;
    }
    public static function getNavigationBadgeColor(): ?string { return 'warning'; }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Quote Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('quote_id')
                        ->label('Quote #')
                        ->disabled()
                        ->hiddenOn('create'),

                    Forms\Components\Select::make('client_id')
                        ->label('Client')
                        ->options(
                            BusinessClient::orderBy('company')->orderBy('firstname')->get()
                                ->mapWithKeys(fn ($c) => [
                                    $c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"
                                ])
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            // Clear linked request when client changes so stale data doesn't carry over
                            $set('request_id', null);
                        }),

                    Forms\Components\Select::make('request_id')
                        ->label('Linked Request')
                        ->placeholder('Select to auto-fill title + line items')
                        ->options(function (Get $get) {
                            $clientId = $get('client_id');
                            if (!$clientId) return [];
                            return ClientRequest::where('client_id', $clientId)
                                ->whereIn('status', ['New', 'InReview', 'Quoted'])
                                ->orderBy('created_at', 'desc')
                                ->get()
                                ->mapWithKeys(fn ($r) => [$r->request_id => "[{$r->request_id}] {$r->title}"]);
                        })
                        ->visible(fn (Get $get) => (bool) $get('client_id'))
                        ->searchable()
                        ->nullable()
                        ->live()
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            if (!$state) return;

                            $request = ClientRequest::with('service')
                                ->where('request_id', $state)
                                ->first();

                            if (!$request) return;

                            $set('job_title', $request->title);

                            if ($request->service) {
                                $svc = $request->service;
                                $set('items', [[
                                    'service_id'  => $svc->service_id,
                                    'description' => $svc->name,
                                    'quantity'    => 1,
                                    'unit_price'  => $svc->unit_price,
                                    'line_total'  => $svc->unit_price,
                                    'sort_order'  => 0,
                                ]]);
                            }
                        })
                        ->helperText('Choosing a request auto-fills the title and adds its service as a line item')
                        ->columnSpanFull(),

                    Forms\Components\Select::make('user_id')
                        ->label('Sales Rep')
                        ->options(User::whereIn('role', ['Admin', 'SalesRep', 'SuperAdmin'])->pluck('name', 'id'))
                        ->default(auth()->id())
                        ->searchable(),

                    Forms\Components\TextInput::make('job_title')
                        ->label('Subject / Title')
                        ->required(),

                    Forms\Components\Select::make('status')
                        ->options(['Draft' => 'Draft', 'Sent' => 'Sent', 'Accepted' => 'Accepted', 'Declined' => 'Declined', 'Expired' => 'Expired'])
                        ->default('Draft')
                        ->required(),

                    Forms\Components\Select::make('opportunity_rating')
                        ->label('Opportunity Rating')
                        ->options([1 => '★', 2 => '★★', 3 => '★★★', 4 => '★★★★', 5 => '★★★★★'])
                        ->default(3),

                    Forms\Components\DateTimePicker::make('quote_date')
                        ->label('Quote Date')
                        ->default(now())
                        ->required(),

                    Forms\Components\DateTimePicker::make('expiry_date')
                        ->label('Expiry Date'),

                    Forms\Components\TextInput::make('required_deposit')
                        ->label('Required Deposit (R)')
                        ->numeric()
                        ->default(0),
                ]),

            Forms\Components\Section::make('Line Items')
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->schema([
                            // Service picker — auto-fills description + unit price
                            Forms\Components\Select::make('service_id')
                                ->label('Service')
                                ->placeholder('Pick service to auto-fill →')
                                ->options(
                                    BusinessService::where('is_active', true)
                                        ->orderBy('category')
                                        ->orderBy('name')
                                        ->get()
                                        ->groupBy('category')
                                        ->map(fn ($g) => $g->pluck('name', 'service_id'))
                                        ->toArray()
                                )
                                ->searchable()
                                ->nullable()
                                ->live()
                                ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                    if (!$state) return;
                                    $svc = BusinessService::where('service_id', $state)->first();
                                    if (!$svc) return;
                                    $set('description', $svc->name);
                                    $set('unit_price', $svc->unit_price);
                                    $qty = (float) ($get('quantity') ?: 1);
                                    $set('line_total', round($qty * $svc->unit_price, 2));
                                })
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('description')
                                ->placeholder('Description')
                                ->required()
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('quantity')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                    $set('line_total', round(((float) $state ?: 0) * ((float) $get('unit_price') ?: 0), 2));
                                })
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('unit_price')
                                ->label('Unit Price (R)')
                                ->numeric()
                                ->default(0)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                    $set('line_total', round(((float) $get('quantity') ?: 1) * ((float) $state ?: 0), 2));
                                })
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('line_total')
                                ->label('Total (R)')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false)
                                ->columnSpan(1),
                        ])
                        ->columns(10)
                        ->addActionLabel('+ Add Line Item')
                        ->reorderable('sort_order')
                        ->defaultItems(1)
                        ->live(),
                ]),

            Forms\Components\Section::make('Notes')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('internal_notes')->label('Internal Notes'),
                    Forms\Components\Textarea::make('client_notes')->label('Client Notes (shown on quote)'),
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
                        ->label('Discount')
                        ->numeric()
                        ->default(0)
                        ->prefix(\App\Models\BusinessSetup::currencySymbol())
                        ->live(onBlur: true),

                    Forms\Components\Placeholder::make('grand_total_display')
                        ->label('Grand Total')
                        ->content(function (Get $get): \Illuminate\Support\HtmlString {
                            $subtotal = collect($get('items') ?? [])
                                ->sum(fn ($i) => (float) ($i['quantity'] ?? 1) * (float) ($i['unit_price'] ?? 0));
                            $discount = (float) ($get('discount') ?? 0);
                            $total    = max(0, $subtotal - $discount);
                            return new \Illuminate\Support\HtmlString(
                                '<span class="text-xl font-bold text-primary-600 dark:text-primary-400">R&nbsp;' . number_format($total, 2) . '</span>'
                            );
                        }),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quote_id')
                    ->label('Quote #')
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray')
                    ->copyable()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.firstname')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => optional($record->client)->full_name ?? '—')
                    ->description(fn ($record) => optional($record->client)->company)
                    ->searchable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold),

                Tables\Columns\TextColumn::make('job_title')
                    ->label('Subject')
                    ->limit(40)
                    ->description(fn ($record) => $record->request_id ? "← {$record->request_id}" : null)
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray'    => 'Draft',
                        'info'    => 'Sent',
                        'success' => 'Accepted',
                        'danger'  => 'Declined',
                        'warning' => 'Expired',
                    ]),

                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Total')
                    ->money(\App\Models\BusinessSetup::current()->currency)
                    ->sortable(),

                Tables\Columns\TextColumn::make('quote_date')
                    ->label('Date')
                    ->date()
                    ->since()
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable(),

                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('Expiry')
                    ->date()
                    ->since()
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable(),

                // Next Action badge
                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        $daysSinceSent = $record->updated_at->diffInDays();
                        $depositPending = $record->required_deposit > 0 && ! $record->deposit_received;
                        return match(true) {
                            $record->status === 'Accepted' && $depositPending  => '💳 Confirm deposit',
                            $record->status === 'Accepted'                     => '🚀 Convert to Job',
                            $record->status === 'Declined'                     => '— Declined',
                            $record->status === 'Expired'                      => '🔄 Re-quote',
                            $record->status === 'Draft'                        => '📤 Send to client',
                            $record->status === 'Sent' && $daysSinceSent > 5  => '⏰ Chase decision',
                            $record->status === 'Sent'                         => '⏳ Awaiting decision',
                            default                                             => '—',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        str_contains($state, '⏰') || str_contains($state, '🔄') => 'danger',
                        str_contains($state, '💳')                               => 'warning',
                        str_contains($state, '📤')                               => 'primary',
                        str_contains($state, '⏳')                               => 'warning',
                        str_contains($state, '🚀')                               => 'success',
                        default                                                   => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['Draft' => 'Draft', 'Sent' => 'Sent', 'Accepted' => 'Accepted', 'Declined' => 'Declined', 'Expired' => 'Expired']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('preview_pdf')
                        ->label('Preview PDF')
                        ->icon('heroicon-o-document-magnifying-glass')
                        ->color('gray')
                        ->url(fn ($record) => route('quote.pdf.preview', $record->quote_id))
                        ->openUrlInNewTab(),

                    Tables\Actions\Action::make('download_pdf')
                        ->label('Download PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('gray')
                        ->url(fn ($record) => route('quote.pdf', $record->quote_id)),

                    // Send with rich preview modal
                    Tables\Actions\Action::make('send')
                        ->label('Send to Client')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('primary')
                        ->visible(fn ($record) => $record->status === 'Draft' && $record->client?->email)
                        ->modalHeading(false)
                        ->modalContent(fn ($record) => view('filament.modals.quote-send-preview', ['quote' => $record]))
                        ->modalWidth('2xl')
                        ->modalSubmitActionLabel('Confirm — Send Now')
                        ->action(function ($record) {
                            $record->update(['status' => 'Sent']);
                            \Illuminate\Support\Facades\Mail::to($record->client->email)
                                ->send(new \App\Mail\QuoteMail($record));
                            \App\Models\ActivityLog::record('sent', 'Quote', $record->quote_id,
                                "Quote {$record->quote_id} sent to {$record->client->email}");
                            \Filament\Notifications\Notification::make()
                                ->title("Quote sent to {$record->client->email}")
                                ->success()->send();
                        }),

                    Tables\Actions\Action::make('mark_accepted')
                        ->label('Mark Accepted')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'Sent')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update(['status' => 'Accepted', 'accepted_at' => now()]);
                            \App\Models\ActivityLog::record('updated', 'Quote', $record->quote_id, "Quote accepted");
                            \Filament\Notifications\Notification::make()->title('Quote Accepted!')->success()->send();
                        }),

                    Tables\Actions\Action::make('mark_deposit_received')
                        ->label('Mark Deposit Received')
                        ->icon('heroicon-o-banknotes')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'Accepted'
                            && $record->required_deposit > 0
                            && ! $record->deposit_received)
                        ->requiresConfirmation()
                        ->modalHeading('Confirm Deposit & Convert to Job')
                        ->modalDescription(fn ($record) => 'Confirm the deposit of R ' . number_format($record->required_deposit, 2) . ' has been received. A job will be created automatically from this quote.')
                        ->modalSubmitActionLabel('Confirm & Create Job')
                        ->action(function ($record) {
                            $record->update([
                                'deposit_received'    => true,
                                'deposit_received_at' => now(),
                            ]);
                            \App\Models\ActivityLog::record('updated', 'Quote', $record->quote_id,
                                "Deposit of R " . number_format($record->required_deposit, 2) . " received — auto-converting to job");
                            $job = $record->load('items')->convertToJob(auth()->id());
                            \Filament\Notifications\Notification::make()
                                ->title("Job {$job->job_id} created")
                                ->body('Deposit confirmed. Redirecting to the new job.')
                                ->success()->send();
                            return redirect()->to(
                                \App\Filament\Resources\JobResource::getUrl('view', ['record' => $job->job_id])
                            );
                        }),

                    Tables\Actions\Action::make('convert_to_job')
                        ->label('Convert to Job')
                        ->icon('heroicon-o-arrow-right-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'Accepted'
                            && ($record->required_deposit == 0 || $record->deposit_received)
                            && $record->job()->doesntExist())
                        ->requiresConfirmation()
                        ->modalHeading('Convert to Job')
                        ->modalDescription(fn ($record) => "Create a job from quote {$record->quote_id}? Line items will be copied across.")
                        ->modalSubmitActionLabel('Create Job')
                        ->action(function ($record) {
                            $job = $record->load('items')->convertToJob(auth()->id());
                            \Filament\Notifications\Notification::make()
                                ->title("Job {$job->job_id} created")
                                ->success()->send();
                            return redirect()->to(
                                \App\Filament\Resources\JobResource::getUrl('view', ['record' => $job->job_id])
                            );
                        }),

                    Tables\Actions\Action::make('mark_declined')
                        ->label('Mark Declined')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => in_array($record->status, ['Sent', 'Draft']))
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update(['status' => 'Declined']);
                            \App\Models\ActivityLog::record('updated', 'Quote', $record->quote_id, "Quote declined");
                            \Filament\Notifications\Notification::make()->title('Quote marked declined')->danger()->send();
                        }),
                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('More'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->modifyQueryUsing(fn ($query) => $query
                ->orderByRaw("FIELD(status, 'Draft', 'Sent', 'Accepted', 'Declined', 'Expired')")
                ->orderBy('quote_date', 'desc')
            )
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'view'   => Pages\ViewQuote::route('/{record}'),
            'edit'   => Pages\EditQuote::route('/{record}/edit'),
        ];
    }
}
