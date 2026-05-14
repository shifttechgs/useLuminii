<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\ActivityLog;
use App\Services\NotificationService;

class ContactFormObserver
{
    public function created(Lead $lead): void
    {
        ActivityLog::record('created', 'Lead', $lead->lead_id,
            "New {$lead->source} lead from {$lead->name}" . ($lead->email ? " <{$lead->email}>" : ''));

        NotificationService::info(
            "New Lead: {$lead->name}",
            (Lead::sourceOptions()[$lead->source] ?? $lead->source) . ($lead->services_interested ? ' — ' . implode(', ', $lead->services_interested) : ''),
            '/useluminii/leads'
        );
    }
}
