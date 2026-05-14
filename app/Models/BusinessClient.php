<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessClient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id', 'business_id', 'user_id', 'firstname', 'lastname',
        'company', 'phone_number', 'email', 'street', 'city', 'province',
        'postal_code', 'country', 'lead_source', 'client_type', 'status',
        'source', 'communication_preference', 'notes',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->client_id)) {
                $model->client_id = 'CLI-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function assignedRep(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'client_id', 'client_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'client_id', 'client_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'client_id', 'client_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(ClientRequest::class, 'client_id', 'client_id');
    }
}

