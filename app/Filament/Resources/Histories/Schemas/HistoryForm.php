<?php

namespace App\Filament\Resources\Histories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('patient_id')
                    ->required(),
                TextInput::make('glucose_level')
                    ->required(),
                TextInput::make('status')
                    ->required(),
            ]);
    }
}
