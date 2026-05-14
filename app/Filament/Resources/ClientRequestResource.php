<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientRequestResource\Pages;
use App\Models\ClientRequest;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ClientRequestResource extends Resource
{
    protected static ?string $model          = ClientRequest::class;
    protected static ?string $navigationIcon  = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?string $navigationLabel = 'Client Requests';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereIn('status', ['New', 'InReview'])->count() ?: null;
    }
    public static function getNavigationBadgeColor(): ?string { return 'warning'; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Request Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('client_id')
                        ->label('Client')
                        ->options(
                            BusinessClient::orderBy('company')->orderBy('firstname')
                                ->get()
                                ->mapWithKeys(fn ($c) => [
                                    $c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"
                                ])
                        )
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('assigned_to')
                        ->label('Assigned To')
                        ->options(
                            User::whereIn('role', ['Admin', 'SalesRep', 'SuperAdmin', 'Engineer'])
                                ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->nullable(),

                    Forms\Components\TextInput::make('title')
                        ->label('Request Title')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Select::make('service_id')
                        ->label('Service')
                        ->options(
                            BusinessService::where('is_active', true)
                                ->orderBy('category')->orderBy('name')
                                ->get()
                                ->groupBy('category')
                                ->map(fn ($group) => $group->pluck('name', 'service_id'))
                                ->toArray()
                        )
                        ->searchable()
                        ->nullable()
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->label('Description / What the client needs')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Status & Priority')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'New'      => 'New',
                            'InReview' => 'In Review',
                            'Quoted'   => 'Quoted',
                            'Approved' => 'Approved',
                            'Closed'   => 'Closed',
                        ])
                        ->default('New')
                        ->required(),

                    Forms\Components\Select::make('priority')
                        ->options([
                            'Low'    => 'Low',
                            'Normal' => 'Normal',
                            'High'   => 'High',
                            'Urgent' => 'Urgent',
                        ])
                        ->default('Normal')
                        ->required(),
                ]),

            Forms\Components\Section::make('Assessment Notes')
                ->schema([
                    Forms\Components\Textarea::make('assessment_notes')
                        ->label('Internal Assessment / Notes')
                        ->rows(4)
                        ->placeholder('Add your evaluation, budget estimate, technical notes…'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request_id')
                    ->label('ID')
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray')
                    ->copyable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Request')
                    ->limit(45)
                    ->searchable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
                    ->description(fn ($record) => ($c = $record->client)
                        ? ($c->company ?: "{$c->firstname} {$c->lastname}")
                        : null),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service')
                    ->placeholder('—')
                    ->badge()
                    ->color('info'),

                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'gray'    => 'Low',
                        'primary' => 'Normal',
                        'warning' => 'High',
                        'danger'  => 'Urgent',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'InReview' => 'In Review',
                        default    => $state,
                    })
                    ->colors([
                        'gray'    => 'New',
                        'warning' => 'InReview',
                        'info'    => 'Quoted',
                        'success' => 'Approved',
                        'danger'  => 'Closed',
                    ]),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assigned')
                    ->placeholder('—')
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Small),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->since()
                    ->sortable()
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),

                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        $days = $record->updated_at->diffInDays();
                        return match(true) {
                            $record->status === 'Closed'                      => '— Closed',
                            $record->status === 'New' && $record->priority === 'Urgent' => '🔴 Review immediately',
                            $record->status === 'New'                         => '👁 Review request',
                            $record->status === 'InReview' && $days > 3      => '⏰ Send quote now',
                            $record->status === 'InReview'                    => '📄 Prepare quote',
                            $record->status === 'Quoted' && $days > 5        => '⏰ Chase approval',
                            $record->status === 'Quoted'                      => '⏳ Awaiting approval',
                            $record->status === 'Approved'                    => '🚀 Start the job',
                            default                                           => '—',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        str_contains($state, '🔴') || str_contains($state, '⏰') => 'danger',
                        str_contains($state, '🚀') || str_contains($state, '👁')  => 'success',
                        str_contains($state, '📄') || str_contains($state, '⏳')  => 'warning',
                        default                                                    => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'New'      => 'New',
                        'InReview' => 'In Review',
                        'Quoted'   => 'Quoted',
                        'Approved' => 'Approved',
                        'Closed'   => 'Closed',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'Low' => 'Low', 'Normal' => 'Normal',
                        'High' => 'High', 'Urgent' => 'Urgent',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('move_in_review')
                        ->label('Mark In Review')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->visible(fn ($record) => $record->status === 'New')
                        ->action(function ($record) {
                            $record->update(['status' => 'InReview']);
                            \App\Models\ActivityLog::record('updated', 'ClientRequest', $record->request_id, "Request '{$record->title}' moved to In Review");
                            \Filament\Notifications\Notification::make()->title('Moved to In Review')->warning()->send();
                        }),

                    Tables\Actions\Action::make('convert_to_quote')
                        ->label('Convert to Quote')
                        ->icon('heroicon-o-document-text')
                        ->color('success')
                        ->visible(fn ($record) => in_array($record->status, ['InReview', 'New']))
                        ->url(fn ($record) => route('filament.admin.resources.quotes.create') . '?client_id=' . $record->client_id . '&request_id=' . $record->request_id . '&title=' . urlencode($record->title)),

                    Tables\Actions\Action::make('mark_approved')
                        ->label('Mark Approved')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'Quoted')
                        ->action(function ($record) {
                            $record->update(['status' => 'Approved']);
                            \App\Models\ActivityLog::record('updated', 'ClientRequest', $record->request_id, "Request '{$record->title}' approved");
                            \Filament\Notifications\Notification::make()->title('Request Approved!')->success()->send();
                        }),

                    Tables\Actions\Action::make('close')
                        ->label('Close Request')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => $record->status !== 'Closed')
                        ->requiresConfirmation()
                        ->modalHeading('Close this request?')
                        ->modalDescription('This will mark the request as closed. You can reopen it by editing.')
                        ->action(function ($record) {
                            $record->update(['status' => 'Closed']);
                            \App\Models\ActivityLog::record('updated', 'ClientRequest', $record->request_id, "Request '{$record->title}' closed");
                            \Filament\Notifications\Notification::make()->title('Request closed')->danger()->send();
                        }),
                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('More'),
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
            'index'  => Pages\ListClientRequests::route('/'),
            'create' => Pages\CreateClientRequest::route('/create'),
            'view'   => Pages\ViewClientRequest::route('/{record}'),
            'edit'   => Pages\EditClientRequest::route('/{record}/edit'),
        ];
    }
}


