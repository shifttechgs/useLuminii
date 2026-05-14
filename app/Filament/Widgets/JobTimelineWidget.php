<?php

namespace App\Filament\Widgets;

use App\Models\JobStatusLog;
use App\Models\Payment;
use Filament\Widgets\Widget;

class JobTimelineWidget extends Widget
{
    protected static string $view = 'filament.widgets.job-timeline';
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = false;
    protected static bool $isDiscovered = false;

    public string $jobId = '';

    public function mount(string $jobId = ''): void
    {
        $this->jobId = $jobId;
    }

    public function getLogs(): \Illuminate\Support\Collection
    {
        return JobStatusLog::with('changedBy')
            ->where('job_id', $this->jobId)
            ->orderBy('created_at')
            ->get();
    }

    public function getPayments(): \Illuminate\Support\Collection
    {
        return Payment::with('recordedBy')
            ->where('quote_id', function ($q) {
                $q->select('quote_id')->from('crm_jobs')->where('job_id', $this->jobId);
            })
            ->orWhere('invoice_id', function ($q) {
                $q->select('invoice_id')->from('invoices')->where('job_id', $this->jobId)->limit(1);
            })
            ->orderBy('received_at')
            ->get();
    }
}
