<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    protected $fillable = [
        'business_id', 'user_id', 'role', 'job_title',
        'phone', 'is_active', 'invited_at', 'joined_at',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'invited_at'  => 'datetime',
        'joined_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

