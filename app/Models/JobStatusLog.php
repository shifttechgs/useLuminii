<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobStatusLog extends Model
{
    protected $fillable = [
        'job_id', 'from_status', 'to_status',
        'note', 'client_notified', 'changed_by',
    ];

    protected $casts = [
        'client_notified' => 'boolean',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function statusColor(): string
    {
        return match($this->to_status) {
            'New'        => '#6b7280',
            'Scheduled'  => '#3b82f6',
            'InProgress' => '#f59e0b',
            'Completed'  => '#10b981',
            'Cancelled'  => '#ef4444',
            default      => '#6b7280',
        };
    }

    public function statusLabel(): string
    {
        return match($this->to_status) {
            'InProgress' => 'In Progress',
            default      => $this->to_status,
        };
    }
}
