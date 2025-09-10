<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); 
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateQrCode')
                ->label('Generate QR Code')
                ->color('success')
                ->icon(Heroicon::QrCode)
                ->url(fn () => route('filament.admin.resources.patients.qr-code', $this->record)),
            DeleteAction::make(),
        ];
    }
}
