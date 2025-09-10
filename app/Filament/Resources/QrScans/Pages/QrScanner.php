<?php

namespace App\Filament\Resources\QrScans\Pages;

use App\Filament\Resources\QrScans\QrScanResource;
use Filament\Resources\Pages\Page;

class QrScanner extends Page
{
    protected static string $resource = QrScanResource::class;

    protected static ?string $title = 'Qr Scanner';

    protected string $view = 'filament.resources.qr-scans.pages.qr-scanner';
}
