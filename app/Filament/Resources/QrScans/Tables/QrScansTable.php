<?php

namespace App\Filament\Resources\QrScans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QrScansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex()
                    ->sortable(false),
                TextColumn::make('patient_id'),
                TextColumn::make('patient.name')
                    ->label('Patient Name')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Scanned By')
                    ->sortable(),
                TextColumn::make('scanned_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('scanned_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
