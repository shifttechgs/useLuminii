<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ClientRequest;
use App\Models\ActivityLog;
use App\Models\Payment;
use App\Models\JobStatusLog;
use App\Services\NotificationService;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quote_id', 'business_id', 'user_id', 'client_id', 'request_id', 'job_title',
        'opportunity_rating', 'required_deposit', 'deposit_received', 'deposit_received_at',
        'internal_notes', 'client_notes', 'currency',
        'status', 'sub_total', 'total_tax', 'grand_total', 'discount', 'discount_type',
        'quote_date', 'expiry_date', 'accepted_token', 'accepted_at',
    ];

    protected $casts = [
        'quote_date'          => 'datetime',
        'expiry_date'         => 'datetime',
        'accepted_at'         => 'datetime',
        'deposit_received_at' => 'datetime',
        'deposit_received'    => 'boolean',
        'sub_total'           => 'decimal:2',
        'total_tax'           => 'decimal:2',
        'grand_total'         => 'decimal:2',
        'required_deposit'    => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->quote_id)) {
                $model->quote_id = 'QUO-' . strtoupper(substr(uniqid(), -6));
            }
            if (empty($model->accepted_token)) {
                $model->accepted_token = \Illuminate\Support\Str::uuid();
            }
        });

        // Drive the full status lifecycle on the linked ClientRequest + push notifications
        static::updated(function (self $model) {
            if (! $model->isDirty('status')) return;

            $quoteLink = '/useluminii/quotes/' . $model->quote_id;
            $clientName = optional($model->client)->company
                ?: (optional($model->client)->firstname . ' ' . optional($model->client)->lastname);

            match ($model->status) {
                'Accepted' => static::handleAccepted($model, $clientName, $quoteLink),
                'Declined' => static::handleDeclined($model, $clientName, $quoteLink),
                'Expired'  => static::handleExpired($model, $clientName, $quoteLink),
                'Sent'     => static::handleSent($model, $clientName, $quoteLink),
                default    => null,
            };
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessClient::class, 'client_id', 'client_id');
    }

    public function salesRep(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class, 'quote_id', 'quote_id')->orderBy('sort_order');
    }

    public function clientRequest(): BelongsTo
    {
        return $this->belongsTo(ClientRequest::class, 'request_id', 'request_id');
    }

    public function job(): HasMany
    {
        return $this->hasMany(Job::class, 'quote_id', 'quote_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(QuoteComment::class, 'quote_id', 'quote_id')->orderBy('created_at');
    }

    // ── Status transition handlers ────────────────────────────────────────────

    private static function handleAccepted(self $model, string $clientName, string $link): void
    {
        if ($model->request_id) {
            ClientRequest::where('request_id', $model->request_id)
                ->whereIn('status', ['Quoted'])
                ->update(['status' => 'Approved']);
        }

        ActivityLog::record('updated', 'Quote', $model->quote_id,
            "Quote {$model->quote_id} accepted by {$clientName}");

        $sym = \App\Models\BusinessSetup::currencySymbol($model->currency);
        NotificationService::success(
            "Quote accepted — {$clientName}",
            "{$model->quote_id} · {$sym} " . number_format($model->grand_total, 2) . ' — ready to convert to a job.',
            $link
        );
    }

    private static function handleDeclined(self $model, string $clientName, string $link): void
    {
        if ($model->request_id) {
            ClientRequest::where('request_id', $model->request_id)
                ->where('status', 'Quoted')
                ->update(['status' => 'InReview']);
        }

        ActivityLog::record('updated', 'Quote', $model->quote_id,
            "Quote {$model->quote_id} declined by {$clientName} — request reverted to In Review");

        NotificationService::warning(
            "Quote declined — {$clientName}",
            "{$model->quote_id} was declined. The request has been moved back to In Review.",
            $link
        );
    }

    private static function handleExpired(self $model, string $clientName, string $link): void
    {
        if ($model->request_id) {
            ClientRequest::where('request_id', $model->request_id)
                ->where('status', 'Quoted')
                ->update(['status' => 'InReview']);
        }

        ActivityLog::record('updated', 'Quote', $model->quote_id,
            "Quote {$model->quote_id} expired — request reverted to In Review for re-quote");

        NotificationService::danger(
            "Quote expired — {$clientName}",
            "{$model->quote_id} passed its expiry date. Revise and resend.",
            $link
        );
    }

    private static function handleSent(self $model, string $clientName, string $link): void
    {
        ActivityLog::record('sent', 'Quote', $model->quote_id,
            "Quote {$model->quote_id} sent to {$clientName}");

        $sym = \App\Models\BusinessSetup::currencySymbol($model->currency);
        NotificationService::info(
            "Quote sent — {$clientName}",
            "{$model->quote_id} · {$sym} " . number_format($model->grand_total, 2) . ' — awaiting client decision.',
            $link
        );
    }

    // ─────────────────────────────────────────────────────────────────────────

    public function convertToJob(?int $convertedByUserId = null): Job
    {
        $job = Job::create([
            'client_id'           => $this->client_id,
            'quote_id'            => $this->quote_id,
            'request_id'          => $this->request_id,
            'user_id'             => $this->user_id,
            'job_title'           => $this->job_title,
            'job_status'          => 'New',
            'job_date_time'       => now(),
            'schedule_later'      => 'no',
            'job_conversion_type' => 'quote',
            'job_converted_by'    => $convertedByUserId,
        ]);

        foreach ($this->items as $item) {
            $job->items()->create([
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'unit_price'  => $item->unit_price,
                'tax_rate'    => $item->tax_rate ?? 15,
                'line_total'  => $item->line_total,
                'sort_order'  => $item->sort_order,
            ]);
        }

        // Record the deposit as a Payment so it flows through to the invoice balance
        if ($this->deposit_received && $this->required_deposit > 0) {
            Payment::create([
                'quote_id'    => $this->quote_id,
                'client_id'   => $this->client_id,
                'amount'      => $this->required_deposit,
                'type'        => 'deposit',
                'method'      => 'eft',
                'reference'   => $this->quote_id,
                'notes'       => "Deposit for quote {$this->quote_id}",
                'received_at' => $this->deposit_received_at ?? now(),
                'recorded_by' => $convertedByUserId,
            ]);
        }

        // Log the initial status
        JobStatusLog::create([
            'job_id'      => $job->job_id,
            'from_status' => null,
            'to_status'   => 'New',
            'note'        => "Job created from quote {$this->quote_id}",
            'changed_by'  => $convertedByUserId,
        ]);

        ActivityLog::record('created', 'Job', $job->job_id,
            "Job {$job->job_id} auto-created from quote {$this->quote_id} on deposit confirmation");

        NotificationService::success(
            "Job created — {$job->job_id}",
            "Quote {$this->quote_id} converted. Job is ready to be scheduled.",
            '/useluminii/jobs/' . $job->job_id
        );

        return $job;
    }

    public function recalculateTotals(): void
    {
        $subTotal = $this->items->sum('line_total');
        $this->sub_total   = $subTotal;
        $this->total_tax   = 0; // VAT not charged yet
        $this->grand_total = $subTotal - ($this->discount ?? 0);
        $this->save();
    }
}


