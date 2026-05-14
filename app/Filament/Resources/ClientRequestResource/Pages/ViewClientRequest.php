<?php namespace App\Filament\Resources\ClientRequestResource\Pages;
use App\Filament\Resources\ClientRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
class ViewClientRequest extends ViewRecord {
    protected static string $resource = ClientRequestResource::class;
    protected function getHeaderActions(): array { return [Actions\EditAction::make()]; }
}

