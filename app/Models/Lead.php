<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lead_id', 'source', 'name', 'email', 'phone', 'company',
        'services_interested', 'message', 'budget',
        'status', 'priority', 'assigned_to', 'admin_notes',
        'contacted_at', 'converted_client_id', 'ip_address', 'original_ref',
    ];

    protected $casts = [
        'budget'              => 'decimal:2',
        'contacted_at'        => 'datetime',
        'services_interested' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'lead_id';
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->lead_id)) {
                $model->lead_id = 'LEA-' . strtoupper(substr(uniqid(), -8));
            }
        });
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function convertedClient()
    {
        return $this->belongsTo(BusinessClient::class, 'converted_client_id');
    }

    public static function sourceOptions(): array
    {
        return [
            'website'  => 'Website Form',
            'call'     => 'Phone Call',
            'referral' => 'Referral',
            'email'    => 'Email',
            'social'   => 'Social Media',
            'manual'   => 'Manual Entry',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            'New'           => 'New',
            'Contacted'     => 'Contacted',
            'Qualified'     => 'Qualified',
            'Proposal Sent' => 'Proposal Sent',
            'Converted'     => 'Converted',
            'Closed'        => 'Closed',
        ];
    }
}
