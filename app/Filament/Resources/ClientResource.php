<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\BusinessClient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ClientResource extends Resource
{
    protected static ?string $model = BusinessClient::class;
    protected static ?string $navigationIcon  = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'CRM';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $modelLabel      = 'Client';
    protected static ?string $pluralModelLabel = 'Clients';
    protected static ?string $recordTitleAttribute = 'firstname';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('client_type', 'Lead')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('firstname')->required()->maxLength(100),
                    Forms\Components\TextInput::make('lastname')->required()->maxLength(100),
                    Forms\Components\TextInput::make('email')->email()->maxLength(255),
                    Forms\Components\TextInput::make('phone_number')->tel()->maxLength(30),
                    Forms\Components\TextInput::make('company')->maxLength(255),
                ]),

            Forms\Components\Section::make('Address')
                ->columns(2)
                ->collapsed()
                ->schema([
                    Forms\Components\TextInput::make('street'),
                    Forms\Components\TextInput::make('city'),
                    Forms\Components\TextInput::make('province'),
                    Forms\Components\TextInput::make('postal_code'),
                    Forms\Components\TextInput::make('country')->default('South Africa'),
                ]),

            Forms\Components\Section::make('CRM Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('client_type')
                        ->options(['Lead' => 'Lead', 'Prospect' => 'Prospect', 'Client' => 'Client'])
                        ->default('Lead')->required(),
                    Forms\Components\Select::make('status')
                        ->options(['Active' => 'Active', 'Inactive' => 'Inactive'])
                        ->default('Active')->required(),
                    Forms\Components\Select::make('lead_source')
                        ->options([
                            'website'    => 'Website Contact Form',
                            'referral'   => 'Referral',
                            'social'     => 'Social Media',
                            'walk-in'    => 'Walk-In',
                            'cold-call'  => 'Cold Call',
                            'other'      => 'Other',
                        ]),
                    Forms\Components\Select::make('communication_preference')
                        ->options([
                            'email'    => 'Email',
                            'phone'    => 'Phone',
                            'whatsapp' => 'WhatsApp',
                        ])->default('email'),
                    Forms\Components\Select::make('user_id')
                        ->label('Assigned Sales Rep')
                        ->options(User::where('role', 'SalesRep')->orWhere('role', 'Admin')->pluck('name', 'id'))
                        ->searchable()->nullable(),
                    Forms\Components\Textarea::make('notes')->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_id')
                    ->label('ID')
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray')
                    ->copyable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('firstname')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => "{$record->firstname} {$record->lastname}")
                    ->description(fn ($record) => $record->company ?: null)
                    ->searchable(['firstname', 'lastname', 'company'])
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold),

                Tables\Columns\TextColumn::make('email')
                    ->label('Contact')
                    ->description(fn ($record) => $record->phone_number ?: null)
                    ->searchable()
                    ->copyable()
                    ->color('gray'),

                Tables\Columns\BadgeColumn::make('client_type')
                    ->label('Type')
                    ->colors([
                        'warning' => 'Lead',
                        'info'    => 'Prospect',
                        'success' => 'Client',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors(['success' => 'Active', 'danger' => 'Inactive']),

                Tables\Columns\TextColumn::make('lead_source')
                    ->label('Source')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'website'   => 'Website',
                        'referral'  => 'Referral',
                        'social'    => 'Social',
                        'walk-in'   => 'Walk-In',
                        'cold-call' => 'Cold Call',
                        default     => ucfirst($state ?? '—'),
                    })
                    ->badge()
                    ->color('gray')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->since()
                    ->sortable()
                    ->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),

                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        $days = $record->created_at->diffInDays();
                        return match(true) {
                            $record->status === 'Inactive'                                    => '💬 Re-engage',
                            $record->client_type === 'Lead' && $days > 5                      => '⏰ Contact overdue',
                            $record->client_type === 'Lead'                                    => '📞 Make first contact',
                            $record->client_type === 'Prospect'                                => '🎯 Qualify prospect',
                            $record->client_type === 'Client' && $record->status === 'Active' => '✅ Maintain relationship',
                            default                                                            => '—',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        str_contains($state, '⏰') || str_contains($state, '💬') => 'danger',
                        str_contains($state, '📞')                                => 'warning',
                        str_contains($state, '🎯')                                => 'primary',
                        str_contains($state, '✅')                                => 'success',
                        default                                                   => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('client_type')
                    ->label('Type')
                    ->options(['Lead' => 'Lead', 'Prospect' => 'Prospect', 'Client' => 'Client']),
                SelectFilter::make('status')
                    ->options(['Active' => 'Active', 'Inactive' => 'Inactive']),
                SelectFilter::make('lead_source')
                    ->label('Source')
                    ->options([
                        'website'   => 'Website',
                        'referral'  => 'Referral',
                        'social'    => 'Social Media',
                        'walk-in'   => 'Walk-In',
                        'cold-call' => 'Cold Call',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),
                Tables\Actions\Action::make('convert')
                    ->label('Make Client')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->size(\Filament\Support\Enums\ActionSize::Small)
                    ->button()
                    ->visible(fn ($record) => $record->client_type !== 'Client')
                    ->requiresConfirmation()
                    ->modalHeading('Convert to Client')
                    ->modalDescription('Mark this contact as a full client?')
                    ->action(fn ($record) => $record->update(['client_type' => 'Client', 'status' => 'Active'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn ($query) => $query
                ->orderByRaw("FIELD(client_type, 'Lead', 'Prospect', 'Client')")
                ->orderBy('created_at', 'asc')
            )
            ->striped();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view'   => Pages\ViewClient::route('/{record}'),
            'edit'   => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}

