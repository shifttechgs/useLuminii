<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteComment extends Model
{
    use \App\Models\Concerns\BelongsToBusiness;

    /** New records take their parent's business (they can be created without a signed-in user). */
    public function businessParents(): array
    {
        return ['quote_id' => [Quote::class, 'quote_id']];
    }

    protected $fillable = [
        'business_id','quote_id', 'author_type', 'author_name', 'message'];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'quote_id');
    }

    public function isFromClient(): bool
    {
        return $this->author_type === 'client';
    }
}
