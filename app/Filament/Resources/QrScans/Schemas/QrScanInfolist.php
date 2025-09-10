<?php

namespace App\Filament\Resources\QrScans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class QrScanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('patient_id'),
                TextEntry::make('scanned_by')
                    ->numeric(),
                TextEntry::make('scanned_at')
                    ->dateTime(),
            ]);
    }
}
