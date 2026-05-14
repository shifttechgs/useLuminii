<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFormSubmission extends Model
{
    protected $fillable = [
        'submission_id', 'name', 'email', 'phone', 'company', 'subject',
        'message', 'service_interest', 'lead_source', 'status',
        'converted_client_id', 'admin_notes', 'ip_address',
        'email_sent_to_admin', 'email_sent_to_client', 'contacted_at',
    ];

    protected $casts = [
        'email_sent_to_admin'  => 'boolean',
        'email_sent_to_client' => 'boolean',
        'contacted_at'         => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->submission_id)) {
                $model->submission_id = 'CF-' . strtoupper(substr(uniqid(), -8));
            }
        });
    }

    public function convertedClient()
    {
        return $this->belongsTo(BusinessClient::class, 'converted_client_id');
    }
}

