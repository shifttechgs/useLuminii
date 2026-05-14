<?php

namespace App\Observers;

use App\Models\Job;
use App\Models\Invoice;
use App\Models\ActivityLog;
use App\Services\NotificationService;

class JobObserver
{
    public function created(Job $job): void
    {
        ActivityLog::record('created', 'Job', $job->job_id,
            "Job {$job->job_id} created: {$job->job_title}");
    }

    public function updated(Job $job): void
    {
        if ($job->isDirty('job_status')) {
            $old = $job->getOriginal('job_status');
            $new = $job->job_status;

            ActivityLog::record('updated', 'Job', $job->job_id,
                "Job {$job->job_id} status: {$old} → {$new}");

            if ($new === 'Completed') {
                NotificationService::success(
                    "Job Completed ✅ {$job->job_id}",
                    "{$job->job_title} has been marked as completed.",
                    '/useluminii/jobs'
                );

                // Auto-create a draft invoice if one doesn't already exist
                if (!Invoice::where('job_id', $job->job_id)->exists()) {
                    Invoice::autoCreateFromJob($job);
                }
            } elseif ($new === 'Cancelled') {
                NotificationService::warning(
                    "Job Cancelled: {$job->job_id}",
                    "{$job->job_title}",
                    '/useluminii/jobs'
                );
            }
        }
    }
}

