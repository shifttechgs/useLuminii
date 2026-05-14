<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'request_id', 'business_id', 'client_id', 'assigned_to',
        'title', 'service_id', 'description', 'status', 'priority', 'assessment_notes',
    ];

    public function service()
    {
        return $this->belongsTo(BusinessService::class, 'service_id', 'service_id');
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->request_id)) {
                $model->request_id = 'REQ-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(BusinessClient::class, 'client_id', 'client_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

