<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\JobResource\Pages;
use App\Models\Job;
use App\Models\BusinessClient;
use App\Models\Quote;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;
    protected static ?string $navigationIcon  = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Operations';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $recordTitleAttribute = 'job_id';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereIn('job_status', ['New','InProgress'])->count() ?: null;
    }
    public static function getNavigationBadgeColor(): ?string { return 'info'; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Job Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('job_id')->label('Job #')->disabled()->hiddenOn('create'),
                    Forms\Components\Select::make('client_id')
                        ->label('Client')->required()
                        ->options(BusinessClient::orderBy('company')->orderBy('firstname')->get()->mapWithKeys(fn ($c) => [$c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"]))
                        ->searchable(),
                    Forms\Components\TextInput::make('job_title')->required(),
                    Forms\Components\Select::make('job_status')
                        ->options(['New'=>'New','Scheduled'=>'Scheduled','InProgress'=>'In Progress','Completed'=>'Completed','Cancelled'=>'Cancelled'])
                        ->default('New')->required(),
                    Forms\Components\Select::make('user_id')->label('Created By / Sales Rep')
                        ->options(User::whereIn('role',['Admin','SalesRep','SuperAdmin'])->pluck('name','id'))->default(auth()->id())->searchable(),
                    Forms\Components\Select::make('team_member_assigned_id')->label('Assign Technician / Engineer')
                        ->options(User::whereIn('role',['Technician','Engineer','Admin'])->pluck('name','id'))->searchable()->nullable(),
                    Forms\Components\Select::make('quote_id')->label('Linked Quote')
                        ->options(Quote::pluck('job_title','quote_id'))->searchable()->nullable(),
                    Forms\Components\DateTimePicker::make('job_date_time')->label('Job Date & Time')->default(now())->required(),
                    Forms\Components\Select::make('schedule_later')
                        ->options(['no'=>'Schedule Now','yes'=>'Schedule Later'])->default('no'),
                ]),

            Forms\Components\Section::make('Line Items')
                ->schema([
                    Forms\Components\Repeater::make('items')->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('description')->required()->columnSpan(3),
                            Forms\Components\TextInput::make('quantity')->numeric()->default(1)->columnSpan(1),
                            Forms\Components\TextInput::make('unit_price')->label('Unit Price (R)')->numeric()->default(0)->columnSpan(1),
                            Forms\Components\TextInput::make('tax_rate')->label('Tax %')->numeric()->default(15)->columnSpan(1),
                        ])->columns(6)->addActionLabel('+ Add Item')->reorderable('sort_order')->defaultItems(1),
                ]),

            Forms\Components\Section::make('Notes & Instructions')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('instructions')->label('Instructions for Technician / Engineer'),
                    Forms\Components\Textarea::make('job_notes')->label('Job Notes'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_id')
                    ->label('Job #')
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray')
                    ->copyable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('job_title')
                    ->label('Job')
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
                    ->description(fn ($record) => optional($record->client)->company
                        ?: trim(optional($record->client)->firstname . ' ' . optional($record->client)->lastname))
                    ->searchable()
                    ->limit(40),

                Tables\Columns\BadgeColumn::make('job_status')
                    ->label('Status')
                    ->colors([
                        'gray'    => 'New',
                        'info'    => 'Scheduled',
                        'warning' => 'InProgress',
                        'success' => 'Completed',
                        'danger'  => 'Cancelled',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'InProgress' => 'In Progress',
                        default      => $state,
                    }),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assigned')
                    ->placeholder('— Unassigned')
                    ->description(fn ($record) => $record->job_date_time
                        ? $record->job_date_time->format('d M Y · H:i')
                        : 'Not scheduled')
                    ->color(fn ($record) => $record->team_member_assigned_id ? null : 'gray'),

                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        $days = $record->updated_at->diffInDays();
                        $hasInvoice = $record->invoice()->exists();
                        $invoiceStatus = $hasInvoice ? $record->invoice->status : null;
                        return match(true) {
                            $record->job_status === 'Cancelled'                                       => '— Cancelled',
                            $record->job_status === 'Completed' && $invoiceStatus === 'Paid'          => '✅ Done',
                            $record->job_status === 'Completed' && $invoiceStatus === 'Draft'         => '📨 Send draft invoice',
                            $record->job_status === 'Completed' && $hasInvoice                        => '⏳ Invoice sent',
                            $record->job_status === 'Completed'                                       => '📄 Create invoice',
                            $record->job_status === 'InProgress' && $days > 3                         => '⏰ Check progress',
                            $record->job_status === 'InProgress'                                      => '⚙ In progress',
                            $record->job_status === 'Scheduled'                                       => '🚀 Ready to start',
                            $record->job_status === 'New' && !$record->team_member_assigned_id
                                && $days > 2                                                          => '⏰ Assign & schedule',
                            $record->job_status === 'New' && !$record->team_member_assigned_id        => '👤 Assign technician',
                            $record->job_status === 'New'                                             => '📅 Schedule job',
                            default                                                                    => '—',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        str_contains($state, '⏰')                               => 'danger',
                        str_contains($state, '📨')                               => 'warning',
                        str_contains($state, '📄') || str_contains($state, '🚀') => 'primary',
                        str_contains($state, '👤') || str_contains($state, '📅') => 'info',
                        str_contains($state, '⚙')  || str_contains($state, '⏳') => 'gray',
                        str_contains($state, '✅')                               => 'success',
                        default                                                   => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('job_status')
                    ->label('Status')
                    ->options(['New' => 'New', 'Scheduled' => 'Scheduled', 'InProgress' => 'In Progress', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('schedule_quick')
                        ->label('Schedule')
                        ->icon('heroicon-o-calendar-days')
                        ->color('info')
                        ->visible(fn ($record) => $record->job_status === 'New')
                        ->fillForm(fn ($record) => [
                            'job_date_time'           => $record->job_date_time ?? now()->addDay(),
                            'team_member_assigned_id' => $record->team_member_assigned_id,
                            'notify_client'           => true,
                        ])
                        ->form([
                            Forms\Components\DateTimePicker::make('job_date_time')
                                ->label('Date & Time')
                                ->required(),
                            Forms\Components\Select::make('team_member_assigned_id')
                                ->label('Assign Technician')
                                ->options(User::whereIn('role', ['Technician', 'Engineer', 'Admin'])->pluck('name', 'id'))
                                ->searchable()
                                ->nullable(),
                            Forms\Components\Toggle::make('notify_client')
                                ->label('Send appointment email to client'),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update([
                                'job_date_time'           => $data['job_date_time'],
                                'team_member_assigned_id' => $data['team_member_assigned_id'] ?? $record->team_member_assigned_id,
                            ]);
                            $record->transitionStatus('Scheduled', null, $data['notify_client'] ?? false);
                            \Filament\Notifications\Notification::make()->title('Job scheduled')->success()->send();
                        }),

                    Tables\Actions\Action::make('start_quick')
                        ->label('Start Job')
                        ->icon('heroicon-o-play-circle')
                        ->color('warning')
                        ->visible(fn ($record) => $record->job_status === 'Scheduled')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->transitionStatus('InProgress')),

                    Tables\Actions\Action::make('complete_quick')
                        ->label('Mark Complete')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn ($record) => $record->job_status === 'InProgress')
                        ->form([
                            Forms\Components\Textarea::make('note')
                                ->label('Completion note')
                                ->rows(2)
                                ->required(),
                            Forms\Components\Toggle::make('notify_client')
                                ->label('Send completion email to client')
                                ->default(true),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update(['job_notes' => $data['note']]);
                            $record->transitionStatus('Completed', $data['note'], $data['notify_client'] ?? true);
                            \Filament\Notifications\Notification::make()->title('Job completed')->success()->send();
                        }),

                    Tables\Actions\Action::make('create_invoice_quick')
                        ->label('Create Invoice')
                        ->icon('heroicon-o-receipt-percent')
                        ->color('primary')
                        ->visible(fn ($record) => $record->job_status === 'Completed' && !$record->invoice()->exists())
                        ->url(fn ($record) => InvoiceResource::getUrl('create', ['job_id' => $record->job_id])),

                    Tables\Actions\Action::make('send_draft_invoice')
                        ->label('Send Invoice')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('warning')
                        ->visible(fn ($record) => $record->job_status === 'Completed'
                            && $record->invoice()->exists()
                            && $record->invoice->status === 'Draft'
                            && $record->invoice->client?->email)
                        ->requiresConfirmation()
                        ->modalHeading('Send Draft Invoice')
                        ->modalDescription(fn ($record) => "Send {$record->invoice->invoice_id} to {$record->invoice->client?->email}?")
                        ->action(function ($record) {
                            $invoice = $record->invoice;
                            $invoice->update(['status' => 'Sent']);
                            \Illuminate\Support\Facades\Mail::to($invoice->client->email)
                                ->send(new \App\Mail\InvoiceMail($invoice));
                            \App\Models\ActivityLog::record('sent', 'Invoice', $invoice->invoice_id,
                                "Invoice {$invoice->invoice_id} sent to {$invoice->client->email} from Jobs list");
                            \Filament\Notifications\Notification::make()
                                ->title("Invoice sent to {$invoice->client->email}")
                                ->success()->send();
                        }),

                    Tables\Actions\Action::make('cancel_quick')
                        ->label('Cancel Job')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => !in_array($record->job_status, ['Completed', 'Cancelled']))
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->transitionStatus('Cancelled')),
                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('More'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->modifyQueryUsing(fn ($query) => $query
                ->orderByRaw("FIELD(job_status, 'InProgress', 'Scheduled', 'New', 'Completed', 'Cancelled')")
                ->orderBy('job_date_time', 'asc')
            )
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'view'   => Pages\ViewJob::route('/{record}'),
            'edit'   => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}



