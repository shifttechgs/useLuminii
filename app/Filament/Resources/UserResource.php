<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('phone')->tel()->nullable(),
                Forms\Components\Select::make('role')
                    ->options(User::ROLES)->required()->default('Admin'),
                Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                Forms\Components\TextInput::make('password')
                    ->password()->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context) => $context === 'create')
                    ->label('Password'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->placeholder('—'),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'danger'  => 'SuperAdmin',
                        'warning' => 'Admin',
                        'info'    => 'SalesRep',
                        'gray'    => 'Technician',
                        'success' => 'Engineer',
                        'primary' => 'Accountant',
                    ]),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('last_login_at')->label('Last Login')->since()->placeholder('Never'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}


