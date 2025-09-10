<?php

namespace App\Filament\Resources\QrScans\Pages;

use App\Filament\Resources\QrScans\QrScanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewQrScan extends ViewRecord
{
    protected static string $resource = QrScanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
