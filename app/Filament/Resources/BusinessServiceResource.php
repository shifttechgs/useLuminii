<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessServiceResource\Pages;
use App\Models\BusinessService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusinessServiceResource extends Resource
{
    protected static ?string $model = BusinessService::class;
    protected static ?string $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Services & Pricing';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        $missing = static::getModel()::where('is_active', true)
            ->where(fn ($q) => $q->whereNull('unit_price')->orWhere('unit_price', 0))
            ->count();

        return $missing ? (string) $missing : null;
    }
    public static function getNavigationBadgeColor(): ?string { return 'warning'; }
    public static function getNavigationBadgeTooltip(): ?string { return 'Active services missing a price'; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Service Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Service Name')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Select::make('category')
                        ->label('Category')
                        ->options([
                            'Web'      => 'Web',
                            'Mobile'   => 'Mobile',
                            'Design'   => 'Design',
                            'Software' => 'Software',
                            'Cloud'    => 'Cloud',
                            'AI'       => 'AI & Automation',
                            'Support'  => 'Support & Maintenance',
                            'Consulting' => 'Consulting',
                            'Other'    => 'Other',
                        ])
                        ->searchable()
                        ->nullable(),

                    Forms\Components\Select::make('unit_type')
                        ->label('Priced Per')
                        ->options([
                            'hour'    => 'Hour',
                            'day'     => 'Day',
                            'item'    => 'Item',
                            'job'     => 'Job (fixed)',
                            'month'   => 'Month',
                        ])
                        ->default('job')
                        ->required(),

                    Forms\Components\TextInput::make('unit_price')
                        ->label('Default Price (R)')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->prefix(\App\Models\BusinessSetup::currencySymbol())
                        ->helperText('This price auto-fills when you select this service on a quote line item')
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->label('Description')
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active (visible in dropdowns)')
                        ->default(true)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_id')
                    ->label('ID')
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray')
                    ->copyable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Service')
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
                    ->description(fn ($record) => $record->description ? \Illuminate\Support\Str::limit($record->description, 60) : null)
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Price (R)')
                    ->money(\App\Models\BusinessSetup::current()->currency)
                    ->sortable()
                    ->color(fn ($state) => $state == 0 ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('unit_type')
                    ->label('Per')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()->iconButton()->tooltip('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Set Active')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Set Inactive')
                        ->icon('heroicon-o-x-circle')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->update(['is_active' => false])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('category')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBusinessServices::route('/'),
            'create' => Pages\CreateBusinessService::route('/create'),
            'edit'   => Pages\EditBusinessService::route('/{record}'),
        ];
    }
}
