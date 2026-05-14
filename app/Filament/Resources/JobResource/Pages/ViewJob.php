<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\JobResource;
use App\Filament\Widgets\JobTimelineWidget;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewJob extends ViewRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ── Schedule Job ─────────────────────────────────────────────────
            Actions\Action::make('schedule')
                ->label('Schedule Job')
                ->icon('heroicon-o-calendar-days')
                ->color('info')
                ->visible(fn () => in_array($this->record->job_status, ['New']))
                ->fillForm(fn () => [
                    'job_date_time'           => $this->record->job_date_time ?? now()->addDay(),
                    'team_member_assigned_id' => $this->record->team_member_assigned_id,
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
                    Forms\Components\Textarea::make('note')
                        ->label('Note (optional)')
                        ->placeholder('Any scheduling notes...')
                        ->rows(2),
                    Forms\Components\Toggle::make('notify_client')
                        ->label('Send appointment confirmation email to client'),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'job_date_time'            => $data['job_date_time'],
                        'team_member_assigned_id'  => $data['team_member_assigned_id'] ?? $this->record->team_member_assigned_id,
                        'schedule_later'           => 'no',
                    ]);
                    $this->record->transitionStatus('Scheduled', $data['note'] ?? null, $data['notify_client'] ?? false);
                    Notification::make()->title('Job scheduled')->success()->send();
                    $this->refreshFormData(['job_status', 'job_date_time', 'team_member_assigned_id']);
                }),

            // ── Assign Technician ────────────────────────────────────────────
            Actions\Action::make('assign')
                ->label('Assign Technician')
                ->icon('heroicon-o-user-plus')
                ->color('gray')
                ->visible(fn () => in_array($this->record->job_status, ['New', 'Scheduled']))
                ->fillForm(fn () => [
                    'team_member_assigned_id' => $this->record->team_member_assigned_id,
                ])
                ->form([
                    Forms\Components\Select::make('team_member_assigned_id')
                        ->label('Technician / Engineer')
                        ->options(User::whereIn('role', ['Technician', 'Engineer', 'Admin'])->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\Textarea::make('note')
                        ->label('Note (optional)')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    $this->record->update(['team_member_assigned_id' => $data['team_member_assigned_id']]);
                    $assignee = User::find($data['team_member_assigned_id']);
                    \App\Models\ActivityLog::record('updated', 'Job', $this->record->job_id,
                        "Assigned to {$assignee?->name}" . ($data['note'] ? " — {$data['note']}" : ''));
                    Notification::make()->title("Assigned to {$assignee?->name}")->success()->send();
                    $this->refreshFormData(['team_member_assigned_id']);
                }),

            // ── Start Job ────────────────────────────────────────────────────
            Actions\Action::make('start')
                ->label('Start Job')
                ->icon('heroicon-o-play-circle')
                ->color('warning')
                ->visible(fn () => $this->record->job_status === 'Scheduled')
                ->form([
                    Forms\Components\Textarea::make('note')
                        ->label('Note (optional)')
                        ->placeholder('e.g. Arrived on site, beginning diagnostics...')
                        ->rows(2),
                    Forms\Components\Toggle::make('notify_client')
                        ->label('Notify client that work has started')
                        ->default(false),
                ])
                ->action(function (array $data) {
                    $this->record->transitionStatus('InProgress', $data['note'] ?? null, $data['notify_client'] ?? false);
                    Notification::make()->title('Job started')->success()->send();
                    $this->refreshFormData(['job_status']);
                }),

            // ── Mark Complete ────────────────────────────────────────────────
            Actions\Action::make('complete')
                ->label('Mark Complete')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn () => $this->record->job_status === 'InProgress')
                ->form([
                    Forms\Components\Textarea::make('note')
                        ->label('Completion note')
                        ->placeholder('Brief summary of work completed...')
                        ->rows(3)
                        ->required(),
                    Forms\Components\Toggle::make('notify_client')
                        ->label('Send completion email to client')
                        ->default(true),
                ])
                ->action(function (array $data) {
                    // Save completion note to job_notes
                    $this->record->update(['job_notes' => $data['note']]);
                    $this->record->transitionStatus('Completed', $data['note'], $data['notify_client'] ?? true);
                    Notification::make()->title('Job marked complete — ready to invoice')->success()->send();
                    $this->refreshFormData(['job_status', 'job_notes']);
                }),

            // ── Create Invoice ───────────────────────────────────────────────
            Actions\Action::make('create_invoice')
                ->label('Create Invoice')
                ->icon('heroicon-o-receipt-percent')
                ->color('success')
                ->visible(fn () => $this->record->job_status === 'Completed' && !$this->record->invoice)
                ->url(fn () => InvoiceResource::getUrl('create', ['job_id' => $this->record->job_id])),

            // ── Cancel Job ───────────────────────────────────────────────────
            Actions\Action::make('cancel')
                ->label('Cancel Job')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => !in_array($this->record->job_status, ['Completed', 'Cancelled']))
                ->requiresConfirmation()
                ->modalHeading('Cancel this job?')
                ->modalDescription('This will mark the job as cancelled and log the change.')
                ->form([
                    Forms\Components\Textarea::make('note')
                        ->label('Reason for cancellation')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    $this->record->transitionStatus('Cancelled', $data['note'] ?? null, false);
                    Notification::make()->title('Job cancelled')->danger()->send();
                    $this->refreshFormData(['job_status']);
                }),

            Actions\EditAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [JobTimelineWidget::class];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getWidgetData(): array
    {
        return ['jobId' => $this->record->job_id];
    }
}
