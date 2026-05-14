<?php

namespace App\Filament\Widgets;

use App\Models\Job;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingJobsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = "Today's Focus";
    protected static ?string $description = "Jobs needing attention today";
    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        $todayStart = now()->startOfDay();
        $todayEnd   = now()->endOfDay();

        return $table
            ->query(
                Job::with(['client', 'assignedTo'])
                    ->whereNull('deleted_at')
                    ->where(function ($q) use ($todayStart, $todayEnd) {
                        $q->where('job_status', 'InProgress')
                          ->orWhere(function ($q2) use ($todayStart, $todayEnd) {
                              $q2->where('job_status', 'Scheduled')
                                 ->whereBetween('job_date_time', [$todayStart, $todayEnd]);
                          })
                          ->orWhere(function ($q3) use ($todayEnd) {
                              $q3->where('job_status', 'New')
                                 ->where('job_date_time', '<=', $todayEnd);
                          });
                    })
                    ->orderByRaw("FIELD(job_status, 'InProgress', 'Scheduled', 'New')")
                    ->orderBy('job_date_time')
                    ->limit(8)
            )
            ->emptyStateHeading('All clear today')
            ->emptyStateDescription('No jobs need attention right now.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->columns([
                Tables\Columns\TextColumn::make('job_title')
                    ->label('Project')
                    ->weight(FontWeight::SemiBold)
                    ->description(fn ($record) =>
                        optional($record->client)->company
                        ?: trim(optional($record->client)->firstname . ' ' . optional($record->client)->lastname)
                    )
                    ->limit(30),

                Tables\Columns\TextColumn::make('job_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'InProgress' ? 'In Progress' : $state)
                    ->color(fn ($state) => match($state) {
                        'InProgress' => 'warning',
                        'Scheduled'  => 'info',
                        default      => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->iconButton()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->tooltip('Open job')
                    ->url(fn (Job $record) => route('filament.admin.resources.jobs.view', $record)),
            ])
            ->paginated(false)
            ->striped();
    }
}
