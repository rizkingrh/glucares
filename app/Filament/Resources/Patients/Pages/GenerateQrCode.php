<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\Patient;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode extends ViewRecord
{
    protected static string $resource = PatientResource::class;
    
    protected static ?string $title = 'Generate QR Code';
    
    public function getView(): string
    {
        return 'filament.resources.patients.pages.generate-qr-code';
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadQrCodePng')
                ->label('Download QR')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->color('success')
                ->url(fn () => route('patient.qr-download', $this->record->id))
                ->openUrlInNewTab(),
        ];
    }
    
    public function getQrCodeSvg(): string
    {
        return QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($this->record->id);
    }

    public function getBreadcrumb(): string
    {
        return 'QR Code';
    }
}
