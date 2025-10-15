<?php

namespace App\Filament\Resources\Histories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient_id')
                    ->label('Patient ID')
                    ->searchable(),
                TextColumn::make('patient.name')
                    ->label('Patient Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('glucose_level')
                    ->label('Glucose Level')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Normal' => 'success',
                        'Rendah' => 'warning', 
                        'Diabetes' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Recorded At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
