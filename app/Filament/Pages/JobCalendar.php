<?php

namespace App\Filament\Pages;

use App\Models\Job;
use App\Models\ScheduledJob;
use App\Models\TeamMember;
use App\Models\ActivityLog;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class JobCalendar extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Operations';
    protected static ?string $navigationLabel = 'Job Calendar';
    protected static ?string $title           = 'Job Scheduling Calendar';
    protected static ?int    $navigationSort  = 2;
    protected static string  $view            = 'filament.pages.job-calendar';

    /**
     * Return all scheduled jobs as FullCalendar events (JSON).
     */
    public function getCalendarEvents(): string
    {
        $events = ScheduledJob::with(['job.client', 'teamMember.user'])
            ->whereNotNull('scheduled_date')
            ->get()
            ->map(function (ScheduledJob $sj) {
                $job    = $sj->job;
                $client = optional($job?->client);
                $member = optional(optional($sj->teamMember)->user);

                $statusColors = [
                    'New'        => '#635bff',
                    'Scheduled'  => '#3b82f6',
                    'InProgress' => '#f59e0b',
                    'Completed'  => '#10b981',
                    'Cancelled'  => '#f43f5e',
                ];

                return [
                    'id'         => $sj->id,
                    'title'      => ($job?->job_title ?? 'Job') . ($member->name ? " — {$member->name}" : ''),
                    'start'      => optional($sj->scheduled_date)->toIso8601String(),
                    'end'        => optional($sj->scheduled_end)->toIso8601String(),
                    'color'      => $statusColors[$job?->job_status ?? 'New'] ?? '#635bff',
                    'extendedProps' => [
                        'jobId'    => $sj->job_id,
                        'status'   => $job?->job_status,
                        'client'   => trim($client->firstname . ' ' . $client->lastname),
                        'location' => $sj->location,
                        'member'   => $member->name,
                        'schedId'  => $sj->id,
                    ],
                ];
            });

        return $events->toJson();
    }

    /**
     * Get unscheduled jobs for the sidebar picker.
     */
    public function getUnscheduledJobs(): \Illuminate\Support\Collection
    {
        $scheduledJobIds = ScheduledJob::pluck('job_id');
        return Job::with('client')
            ->whereNotIn('job_id', $scheduledJobIds)
            ->whereNotIn('job_status', ['Completed', 'Cancelled'])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();
    }

    public function scheduleJob(array $data): void
    {
        $existing = ScheduledJob::where('job_id', $data['job_id'])->first();

        if ($existing) {
            $existing->update([
                'scheduled_date'  => $data['scheduled_date'],
                'scheduled_end'   => $data['scheduled_end'] ?? null,
                'team_member_id'  => $data['team_member_id'] ?? null,
                'location'        => $data['location'] ?? null,
                'job_type'        => $data['job_type'] ?? 'Once-off',
                'notes'           => $data['notes'] ?? null,
                'status'          => 'Scheduled',
            ]);
        } else {
            ScheduledJob::create([
                'job_id'          => $data['job_id'],
                'scheduled_date'  => $data['scheduled_date'],
                'scheduled_end'   => $data['scheduled_end'] ?? null,
                'team_member_id'  => $data['team_member_id'] ?? null,
                'location'        => $data['location'] ?? null,
                'job_type'        => $data['job_type'] ?? 'Once-off',
                'notes'           => $data['notes'] ?? null,
                'status'          => 'Scheduled',
            ]);
        }

        // Update job status
        Job::where('job_id', $data['job_id'])->update([
            'job_status'      => 'Scheduled',
            'scheduled_status'=> 'Scheduled',
            'assigned_status' => isset($data['team_member_id']) ? 'Assigned' : 'Unassigned',
            'job_date_time'   => $data['scheduled_date'],
        ]);

        ActivityLog::record('updated', 'Job', $data['job_id'],
            "Job {$data['job_id']} scheduled for " . \Carbon\Carbon::parse($data['scheduled_date'])->format('d M Y H:i'));

        Notification::make()->title('Job scheduled successfully')->success()->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('scheduleJob')
                ->label('Schedule a Job')
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->form([
                    Select::make('job_id')
                        ->label('Job')
                        ->options(
                            Job::with('client')
                                ->whereNotIn('job_status', ['Completed', 'Cancelled'])
                                ->whereNull('deleted_at')
                                ->get()
                                ->mapWithKeys(fn ($j) => [
                                    $j->job_id => $j->job_id . ' — ' . ($j->job_title ?? 'Untitled') .
                                        (optional($j->client)->firstname ? ' (' . $j->client->firstname . ')' : '')
                                ])
                        )
                        ->searchable()
                        ->required(),

                    Select::make('team_member_id')
                        ->label('Assign Team Member')
                        ->options(
                            TeamMember::with('user')->where('is_active', true)->get()
                                ->mapWithKeys(fn ($m) => [$m->id => optional($m->user)->name . " ({$m->role})"])
                        )
                        ->searchable()
                        ->nullable(),

                    Select::make('job_type')
                        ->options(['Once-off' => 'Once-off', 'Recurring' => 'Recurring'])
                        ->default('Once-off'),

                    DateTimePicker::make('scheduled_date')->label('Start Date & Time')->required(),
                    DateTimePicker::make('scheduled_end')->label('End Date & Time')->nullable(),

                    TextInput::make('location')->placeholder('e.g. 12 Main St, Cape Town')->nullable(),
                    Textarea::make('notes')->label('Notes')->nullable(),
                ])
                ->action(fn (array $data) => $this->scheduleJob($data)),
        ];
    }
}

