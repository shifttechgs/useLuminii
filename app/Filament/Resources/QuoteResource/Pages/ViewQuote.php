<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\JobResource;
use App\Filament\Resources\QuoteResource;
use App\Filament\Widgets\QuoteCommentsWidget;
use App\Models\ActivityLog;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Deposit pending → confirm + auto-create job
            Actions\Action::make('mark_deposit_received')
                ->label('Confirm Deposit Received')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->visible(fn () => $this->record->status === 'Accepted'
                    && $this->record->required_deposit > 0
                    && ! $this->record->deposit_received)
                ->requiresConfirmation()
                ->modalHeading('Confirm Deposit & Convert to Job')
                ->modalDescription(fn () => 'Confirm the deposit of R ' . number_format($this->record->required_deposit, 2) . ' has been received. A job will be created automatically from this quote.')
                ->modalSubmitActionLabel('Confirm & Create Job')
                ->action(function () {
                    $this->record->update([
                        'deposit_received'    => true,
                        'deposit_received_at' => now(),
                    ]);
                    ActivityLog::record('updated', 'Quote', $this->record->quote_id,
                        'Deposit of R ' . number_format($this->record->required_deposit, 2) . ' received — auto-converting to job');
                    $job = $this->record->load('items')->convertToJob(auth()->id());
                    Notification::make()
                        ->title("Job {$job->job_id} created")
                        ->body('Deposit confirmed. Redirecting to the new job.')
                        ->success()->send();
                    $this->redirect(JobResource::getUrl('view', ['record' => $job->job_id]));
                }),

            // Deposit already received but job not yet created (e.g. retry after a failure)
            Actions\Action::make('create_job_from_quote')
                ->label('Create Job')
                ->icon('heroicon-o-arrow-right-circle')
                ->color('success')
                ->visible(fn () => $this->record->status === 'Accepted'
                    && ($this->record->required_deposit == 0 || $this->record->deposit_received)
                    && $this->record->job()->doesntExist())
                ->requiresConfirmation()
                ->modalHeading('Create Job from Quote')
                ->modalDescription(fn () => "Create a job from quote {$this->record->quote_id}? Line items will be copied across.")
                ->modalSubmitActionLabel('Create Job')
                ->action(function () {
                    $job = $this->record->load('items')->convertToJob(auth()->id());
                    Notification::make()
                        ->title("Job {$job->job_id} created")
                        ->success()->send();
                    $this->redirect(JobResource::getUrl('view', ['record' => $job->job_id]));
                }),

            // Deposit received indicator (read-only, shows confirmed date)
            Actions\Action::make('deposit_received_badge')
                ->label(fn () => 'Deposit Received ' . ($this->record->deposit_received_at?->format('d M Y') ?? ''))
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn () => $this->record->deposit_received)
                ->disabled()
                ->action(fn () => null),

            // No deposit required → direct convert
            Actions\Action::make('no_deposit_convert')
                ->label('Convert to Job')
                ->icon('heroicon-o-arrow-right-circle')
                ->color('success')
                ->visible(fn () => $this->record->status === 'Accepted'
                    && $this->record->required_deposit == 0
                    && $this->record->job()->doesntExist())
                ->requiresConfirmation()
                ->modalHeading('Convert to Job')
                ->modalDescription(fn () => "Create a job from quote {$this->record->quote_id}?")
                ->modalSubmitActionLabel('Create Job')
                ->action(function () {
                    $job = $this->record->load('items')->convertToJob(auth()->id());
                    Notification::make()->title("Job {$job->job_id} created")->success()->send();
                    $this->redirect(JobResource::getUrl('view', ['record' => $job->job_id]));
                }),

            Actions\EditAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [QuoteCommentsWidget::class];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getWidgetData(): array
    {
        return ['quoteId' => $this->record->quote_id];
    }
}
