<?php

namespace App\Filament\Resources\QrScans\Pages;

use App\Filament\Resources\QrScans\QrScanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditQrScan extends EditRecord
{
    protected static string $resource = QrScanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
