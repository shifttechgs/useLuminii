<?php

namespace App\Models;

use App\Models\ActivityLog;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Job extends Model
{
    use SoftDeletes;

    protected $table = 'crm_jobs';

    public function getRouteKeyName(): string
    {
        return 'job_id';
    }
    protected $fillable = [
        'job_id', 'business_id', 'user_id', 'client_id', 'quote_id', 'request_id',
        'job_title', 'instructions', 'job_notes', 'job_status',
        'scheduled_status', 'assigned_status', 'team_member_assigned_id',
        'job_conversion_type', 'job_converted_by', 'invoicing_reminder',
        'schedule_later', 'job_date_time',
    ];

    protected $casts = [
        'job_date_time' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->job_id)) {
                $model->job_id = 'JOB-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessClient::class, 'client_id', 'client_id');
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'quote_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_member_assigned_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clientRequest(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ClientRequest::class, 'request_id', 'request_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(JobItem::class, 'job_id', 'job_id')->orderBy('sort_order');
    }

    public function scheduledJob(): HasOne
    {
        return $this->hasOne(ScheduledJob::class, 'job_id', 'job_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'job_id', 'job_id');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(JobStatusLog::class, 'job_id', 'job_id')->orderBy('created_at');
    }

    /**
     * Transition job status, log the change, optionally notify the client by email.
     */
    public function transitionStatus(string $toStatus, ?string $note = null, bool $notifyClient = false): void
    {
        $fromStatus = $this->job_status;

        $this->update(['job_status' => $toStatus]);

        JobStatusLog::create([
            'job_id'          => $this->job_id,
            'from_status'     => $fromStatus,
            'to_status'       => $toStatus,
            'note'            => $note,
            'client_notified' => $notifyClient,
            'changed_by'      => auth()->id(),
        ]);

        $clientName = optional($this->client)->company
            ?: trim(optional($this->client)->firstname . ' ' . optional($this->client)->lastname);

        ActivityLog::record('updated', 'Job', $this->job_id,
            "Job status changed: {$fromStatus} → {$toStatus}" . ($note ? " — {$note}" : ''));

        if ($notifyClient && $this->client?->email) {
            match($toStatus) {
                'Scheduled'  => \Illuminate\Support\Facades\Mail::to($this->client->email)
                                    ->send(new \App\Mail\JobScheduledMail($this)),
                'Completed'  => \Illuminate\Support\Facades\Mail::to($this->client->email)
                                    ->send(new \App\Mail\JobCompletedMail($this)),
                default      => null,
            };
        }

        $link = '/useluminii/jobs/' . $this->job_id;
        match($toStatus) {
            'Scheduled'  => NotificationService::info("Job Scheduled — {$clientName}", "{$this->job_id} · {$this->job_date_time?->format('d M Y H:i')}", $link),
            'InProgress' => NotificationService::info("Job Started — {$clientName}", "{$this->job_id} is now in progress.", $link),
            'Completed'  => NotificationService::success("Job Completed — {$clientName}", "{$this->job_id} · Ready to invoice.", $link),
            'Cancelled'  => NotificationService::warning("Job Cancelled — {$clientName}", "{$this->job_id} has been cancelled.", $link),
            default      => null,
        };
    }
}




