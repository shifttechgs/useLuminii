<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    protected static ?string $navigationIcon  = 'heroicon-o-funnel';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationLabel = 'Leads';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereIn('status', ['New', 'Contacted'])->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Contact Information')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(150),

                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(30),

                    Forms\Components\TextInput::make('company')
                        ->maxLength(100),
                ]),

            Forms\Components\Section::make('Lead Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('source')
                        ->options(Lead::sourceOptions())
                        ->default('manual')
                        ->required(),

                    Forms\Components\TextInput::make('budget')
                        ->numeric()
                        ->prefix(\App\Models\BusinessSetup::currencySymbol())
                        ->placeholder('0.00'),

                    Forms\Components\CheckboxList::make('services_interested')
                        ->label('Services Interested In')
                        ->options(
                            BusinessService::where('is_active', true)
                                ->orderBy('category')->orderBy('name')
                                ->pluck('name', 'name')
                        )
                        ->columns(2)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('message')
                        ->label('Message / Project Brief')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Pipeline')
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options(Lead::statusOptions())
                        ->default('New')
                        ->required(),

                    Forms\Components\Select::make('priority')
                        ->options(['Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High', 'Urgent' => 'Urgent'])
                        ->default('Normal')
                        ->required(),

                    Forms\Components\Select::make('assigned_to')
                        ->label('Assigned To')
                        ->options(User::whereIn('role', ['Admin', 'SalesRep', 'SuperAdmin'])->pluck('name', 'id'))
                        ->searchable()
                        ->nullable(),
                ]),

            Forms\Components\Section::make('Internal Notes')
                ->schema([
                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Notes')
                        ->rows(3)
                        ->placeholder('Qualification notes, call summary, next steps…'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Lead')
                    ->searchable()
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
                    ->description(fn ($record) => $record->company ?: $record->email),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray'    => 'New',
                        'info'    => 'Contacted',
                        'primary' => 'Qualified',
                        'warning' => 'Proposal Sent',
                        'success' => 'Converted',
                        'danger'  => 'Closed',
                    ]),

                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'gray'    => 'Low',
                        'primary' => 'Normal',
                        'warning' => 'High',
                        'danger'  => 'Urgent',
                    ]),

                Tables\Columns\TextColumn::make('budget')
                    ->label('Budget')
                    ->money(\App\Models\BusinessSetup::current()->currency)
                    ->placeholder('—')
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Small),

                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        $days = $record->created_at->diffInDays();
                        return match(true) {
                            in_array($record->status, ['Converted', 'Closed'])                              => '— Done',
                            $record->status === 'New' && $record->priority === 'Urgent'                    => '🔴 Call immediately',
                            $record->status === 'New' && $record->priority === 'High'                      => '📞 Call today',
                            $record->status === 'New' && $days > 2                                         => '📧 Overdue outreach',
                            $record->status === 'New'                                                       => '📧 Reach out',
                            $record->status === 'Contacted' && $days > 3                                   => '⏰ Follow up now',
                            $record->status === 'Contacted'                                                 => '✔ Qualify lead',
                            $record->status === 'Qualified'                                                 => '📄 Send proposal',
                            $record->status === 'Proposal Sent' && $record->updated_at->diffInDays() > 5  => '⏰ Chase decision',
                            $record->status === 'Proposal Sent'                                            => '⏳ Awaiting decision',
                            default                                                                         => '—',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        str_contains($state, '🔴') || str_contains($state, '⏰') => 'danger',
                        str_contains($state, '📞') || str_contains($state, '⏳') => 'warning',
                        str_contains($state, '📄') || str_contains($state, '✔')  => 'primary',
                        str_contains($state, '📧')                                => 'info',
                        default                                                   => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')->options(Lead::statusOptions()),
                SelectFilter::make('source')->options(Lead::sourceOptions()),
                SelectFilter::make('priority')
                    ->options(['Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High', 'Urgent' => 'Urgent']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('mark_contacted')
                        ->label('Mark as Contacted')
                        ->icon('heroicon-o-phone')
                        ->color('info')
                        ->visible(fn ($record) => $record->status === 'New')
                        ->action(function ($record) {
                            $record->update(['status' => 'Contacted', 'contacted_at' => now()]);
                            Notification::make()->title('Marked as Contacted')->info()->send();
                        }),

                    Tables\Actions\Action::make('mark_qualified')
                        ->label('Mark as Qualified')
                        ->icon('heroicon-o-check-badge')
                        ->color('primary')
                        ->visible(fn ($record) => in_array($record->status, ['New', 'Contacted']))
                        ->action(function ($record) {
                            $record->update(['status' => 'Qualified']);
                            Notification::make()->title('Lead Qualified')->success()->send();
                        }),

                    Tables\Actions\Action::make('convert_to_client')
                        ->label('Convert to Client')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->visible(fn ($record) => ! in_array($record->status, ['Converted', 'Closed']))
                        ->requiresConfirmation()
                        ->modalHeading('Convert lead to client?')
                        ->modalDescription('This will create a new Client record and mark this lead as Converted.')
                        ->modalSubmitActionLabel('Yes, convert')
                        ->action(function ($record) {
                            $nameParts = explode(' ', $record->name, 2);
                            $client = BusinessClient::create([
                                'firstname'    => $nameParts[0],
                                'lastname'     => $nameParts[1] ?? '—',
                                'email'        => $record->email,
                                'phone_number' => $record->phone,
                                'company'      => $record->company,
                                'lead_source'  => $record->source,
                                'client_type'  => 'Client',
                            ]);
                            $record->update([
                                'status'              => 'Converted',
                                'converted_client_id' => $client->id,
                            ]);
                            \App\Models\ActivityLog::record('converted', 'Lead', $record->lead_id, "Lead {$record->name} converted to client");
                            Notification::make()->title("Client created: {$client->firstname} {$client->lastname}")->success()->send();
                        }),

                    Tables\Actions\Action::make('close')
                        ->label('Close Lead')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => ! in_array($record->status, ['Converted', 'Closed']))
                        ->requiresConfirmation()
                        ->modalHeading('Close this lead?')
                        ->modalDescription('The lead will be marked as Closed. You can reopen it by editing.')
                        ->action(function ($record) {
                            $record->update(['status' => 'Closed']);
                            Notification::make()->title('Lead closed')->danger()->send();
                        }),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('More'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('bulk_close')
                        ->label('Close Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'Closed'])),
                ]),
            ])
            ->modifyQueryUsing(fn ($query) => $query
                ->orderByRaw("FIELD(priority, 'Urgent', 'High', 'Normal', 'Low')")
                ->orderBy('created_at', 'asc')
            )
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'view'   => Pages\ViewLead::route('/{record}'),
            'edit'   => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
