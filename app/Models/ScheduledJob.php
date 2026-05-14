<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledJob extends Model
{
    protected $fillable = [
        'job_id', 'team_member_id', 'job_type', 'scheduled_date', 'scheduled_end',
        'repeats', 'repeat_duration', 'status', 'location', 'notes', 'internal_notes',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'scheduled_end'  => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }
}
