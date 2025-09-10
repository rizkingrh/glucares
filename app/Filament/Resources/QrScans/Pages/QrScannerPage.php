<?php

namespace App\Filament\Resources\QrScans\Pages;

use App\Filament\Resources\QrScans\QrScanResource;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;

class QrScannerPage extends Page
{
    protected static string $resource = QrScanResource::class;
    
    protected static ?string $title = 'QR Code Scanner';

    public function render(): View
    {
        return view('filament.resources.qr-scans.pages.qr-scanner');
    }
}