<?php

namespace App\Filament\Resources\BusinessServiceResource\Pages;

use App\Filament\Resources\BusinessServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessService extends EditRecord
{
    protected static string $resource = BusinessServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
