<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\TextInput::make('vendor')->nullable(),
                Forms\Components\Select::make('category_id')->label('Category')
                    ->options(ExpenseCategory::orderBy('sort_order')->pluck('name', 'id'))->searchable()->nullable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\ColorPicker::make('color')->default('#6366f1'),
                        Forms\Components\TextInput::make('sort_order')->numeric()->default(99),
                    ])
                    ->createOptionUsing(fn (array $data) => ExpenseCategory::create($data)->id),
                Forms\Components\TextInput::make('amount')->label('Amount (R)')->numeric()->required(),
                Forms\Components\DatePicker::make('expense_date')->label('Date')->default(now())->required(),
                Forms\Components\Select::make('recurrence_type')->label('Recurrence')
                    ->options(['none'=>'One-time','weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly'])->default('none'),
                Forms\Components\Toggle::make('is_recurring')->label('Recurring Expense')->reactive(),
                Forms\Components\Textarea::make('notes')->columnSpanFull(),
                Forms\Components\FileUpload::make('receipt_path')
                    ->label('Receipt / Proof of Payment')
                    ->disk('public')
                    ->directory('receipts')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                    ->maxSize(4096)
                    ->columnSpanFull()
                    ->nullable(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('expense_id')
                    ->label('ID')->copyable()->sortable()->searchable()
                    ->fontFamily('mono')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('description')
                    ->weight(FontWeight::SemiBold)
                    ->description(fn ($record) => $record->vendor ?: null)
                    ->searchable()->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')->placeholder('—')
                    ->badge()->color('gray'),

                Tables\Columns\TextColumn::make('amount')->money(\App\Models\BusinessSetup::current()->currency)->sortable(),

                Tables\Columns\TextColumn::make('expense_date')
                    ->label('Date')->date()->sortable()
                    ->since()->color('gray')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),

                Tables\Columns\IconColumn::make('receipt_path')->label('Receipt')
                    ->boolean()
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('heroicon-o-minus')
                    ->getStateUsing(fn ($record) => ! empty($record->receipt_path)),

                Tables\Columns\TextColumn::make('next_action')
                    ->label('Next Action')
                    ->getStateUsing(function ($record) {
                        $days = \Carbon\Carbon::parse($record->expense_date)->diffInDays(now(), false);
                        return match (true) {
                            empty($record->receipt_path) && $days <= 7  => '📎 Attach receipt',
                            empty($record->receipt_path) && $days > 7   => '⚠ Receipt missing',
                            $record->is_recurring                        => '🔁 Recurring',
                            default                                      => '✅ Filed',
                        };
                    })
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        str_contains($state, '⚠')  => 'danger',
                        str_contains($state, '📎') => 'warning',
                        str_contains($state, '🔁') => 'info',
                        str_contains($state, '✅') => 'success',
                        default                     => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('category_id')->label('Category')
                    ->options(ExpenseCategory::pluck('name', 'id')),
                SelectFilter::make('is_recurring')->label('Type')
                    ->options(['1' => 'Recurring', '0' => 'One-time']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_receipt')
                        ->label('View Receipt')
                        ->icon('heroicon-o-paper-clip')
                        ->color('gray')
                        ->visible(fn ($record) => ! empty($record->receipt_path))
                        ->url(fn ($record) => \Illuminate\Support\Facades\Storage::url($record->receipt_path))
                        ->openUrlInNewTab(),

                    Tables\Actions\DeleteAction::make(),
                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('More'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->striped()
            ->defaultSort('expense_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit'   => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}




