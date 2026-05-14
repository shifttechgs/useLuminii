<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'business_id', 'user_id', 'action', 'entity_type',
        'entity_id', 'description', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, string $entityType, string $entityId, string $description, array $meta = []): void
    {
        static::create([
            'business_id' => config('crm.business_id'),
            'user_id'     => auth()->id(),
            'action'      => $action,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'description' => $description,
            'meta'        => $meta,
        ]);
    }
}

