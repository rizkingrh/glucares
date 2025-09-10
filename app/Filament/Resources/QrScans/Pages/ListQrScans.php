<?php

namespace App\Filament\Resources\QrScans\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\QrScans\QrScanResource;
use Filament\Support\Icons\Heroicon;

class ListQrScans extends ListRecords
{
    protected static string $resource = QrScanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('scanQr')
                ->label('Scan QR Code')
                ->icon(Heroicon::OutlinedQrCode)
                ->color('success')
                ->url(fn () => route('filament.admin.resources.qr-scans.scanner'))
                ->openUrlInNewTab(false),
        ];
    }
}
