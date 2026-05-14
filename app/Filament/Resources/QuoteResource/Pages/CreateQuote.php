<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use App\Models\ActivityLog;
use App\Models\ClientRequest;
use Filament\Resources\Pages\CreateRecord;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;

    public function mount(): void
    {
        parent::mount();

        $clientId  = request()->query('client_id');
        $requestId = request()->query('request_id');
        $title     = request()->query('title');

        $data = [];

        if ($clientId)  $data['client_id']  = $clientId;
        if ($title)     $data['job_title']   = urldecode($title);
        if ($requestId) $data['request_id']  = $requestId;

        // Auto-populate first line item from the linked request's service
        if ($requestId) {
            $request = ClientRequest::with('service')
                ->where('request_id', $requestId)
                ->first();

            if ($request?->service) {
                $svc = $request->service;
                $data['items'] = [[
                    'service_id'  => $svc->service_id,
                    'description' => $svc->name,
                    'quantity'    => 1,
                    'unit_price'  => $svc->unit_price,
                    'line_total'  => $svc->unit_price,
                    'sort_order'  => 0,
                ]];
            }
        }

        if (!empty($data)) {
            $this->form->fill($data);
        }
    }

    protected function afterCreate(): void
    {
        // Recalculate totals now that items are persisted
        $this->record->load('items')->recalculateTotals();

        // Auto-update linked ClientRequest → Quoted
        $requestId = $this->record->request_id;
        if ($requestId) {
            ClientRequest::where('request_id', $requestId)
                ->whereIn('status', ['New', 'InReview'])
                ->update(['status' => 'Quoted']);

            ActivityLog::record('updated', 'ClientRequest', $requestId,
                "Status set to Quoted via quote {$this->record->quote_id}");
        }

        ActivityLog::record('created', 'Quote', $this->record->quote_id,
            "Quote {$this->record->quote_id} created for client {$this->record->client_id}");
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
