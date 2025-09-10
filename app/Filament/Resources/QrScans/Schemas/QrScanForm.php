<?php

namespace App\Filament\Resources\QrScans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class QrScanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([             
                Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->required()
                    ->label('Patient'),
                Select::make('scanned_by')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->label('Scanned By'),
                DateTimePicker::make('scanned_at')
                    ->default(now())
                    ->label('Scanned At')
                    ->required(),
            ]);
    }
}
