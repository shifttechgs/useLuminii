<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteComment extends Model
{
    protected $fillable = ['quote_id', 'author_type', 'author_name', 'message'];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'quote_id');
    }

    public function isFromClient(): bool
    {
        return $this->author_type === 'client';
    }
}
