<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Mail\TeamMemberInvite;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\BusinessSetup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;
    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Member Details')->columns(2)->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User Account')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('role')
                    ->options([
                        'Admin'       => 'Admin',
                        'SalesRep'    => 'Sales Rep',
                        'Technician'  => 'Technician',
                        'Engineer'    => 'Engineer',
                        'Accountant'  => 'Accountant',
                        'Support'     => 'Support',
                    ])
                    ->required()
                    ->default('Technician'),

                Forms\Components\TextInput::make('job_title')->nullable(),
                Forms\Components\TextInput::make('phone')->tel()->nullable(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('user.email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Admin'      => 'danger',
                        'SalesRep'   => 'warning',
                        'Technician' => 'info',
                        'Engineer'   => 'success',
                        'Accountant' => 'gray',
                        default      => 'gray',
                    }),
                Tables\Columns\TextColumn::make('job_title')->placeholder('—'),
                Tables\Columns\TextColumn::make('phone')->placeholder('—'),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('joined_at')->label('Joined')->date()->placeholder('Pending'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('invite')
                    ->label('Resend Invite')
                    ->icon('heroicon-o-envelope')
                    ->color('warning')
                    ->action(function (TeamMember $record) {
                        $user = $record->user;
                        if (! $user) {
                            Notification::make()->title('No user linked.')->danger()->send();
                            return;
                        }
                        $tempPassword = Str::random(12);
                        $user->update(['password' => Hash::make($tempPassword)]);
                        $record->update(['invited_at' => now()]);

                        $bizName = optional(BusinessSetup::first())->business_name ?? config('app.name');

                        Mail::to($user->email)->send(new TeamMemberInvite(
                            inviteeName: $user->name,
                            businessName: $bizName,
                            role: $record->role,
                            tempPassword: $tempPassword,
                            loginUrl: url('/useluminii'),
                        ));

                        Notification::make()->title("Invite sent to {$user->email}")->success()->send();
                    })
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Action::make('invite_new')
                    ->label('Invite New Member')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->form([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('email')->email()->required(),
                        Forms\Components\Select::make('role')
                            ->options([
                                'Admin' => 'Admin', 'SalesRep' => 'Sales Rep',
                                'Technician' => 'Technician', 'Engineer' => 'Engineer',
                                'Accountant' => 'Accountant', 'Support' => 'Support',
                            ])
                            ->default('Technician')
                            ->required(),
                        Forms\Components\TextInput::make('job_title')->nullable(),
                        Forms\Components\TextInput::make('phone')->tel()->nullable(),
                    ])
                    ->action(function (array $data) {
                        $tempPassword = Str::random(12);
                        $user = User::create([
                            'name'     => $data['name'],
                            'email'    => $data['email'],
                            'password' => Hash::make($tempPassword),
                            'role'     => strtolower($data['role']),
                        ]);

                        $member = TeamMember::create([
                            'user_id'   => $user->id,
                            'role'      => $data['role'],
                            'job_title' => $data['job_title'] ?? null,
                            'phone'     => $data['phone'] ?? null,
                            'is_active' => true,
                            'invited_at'=> now(),
                        ]);

                        $bizName = optional(BusinessSetup::first())->business_name ?? config('app.name');

                        Mail::to($user->email)->send(new TeamMemberInvite(
                            inviteeName: $user->name,
                            businessName: $bizName,
                            role: $member->role,
                            tempPassword: $tempPassword,
                            loginUrl: url('/useluminii'),
                        ));

                        Notification::make()->title("Invitation sent to {$user->email}")->success()->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit'   => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}




