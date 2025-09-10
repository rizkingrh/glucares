<?php

namespace App\Filament\Resources\Patients\Tables;

use Dom\Text;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('date_of_birth')->label('Date of Birth')->date()->sortable(),
                TextColumn::make('marital_status')->label('Marital Status')->colors(['primary' => 'Single', 'success' => 'Married']),
                TextColumn::make('address')->label('Address')->limit(25)->wrap(),
                TextColumn::make('phone_number')->label('Phone Number')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('marital_status')
                    ->options([
                        'Single' => 'Single',
                        'Married' => 'Married',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('generateQrCode')
                    ->label('QR Code')
                    ->color('success')
                    ->icon(Heroicon::QrCode)
                    ->url(fn ($record) => route('filament.admin.resources.patients.qr-code', $record)),
                Action::make('view')
                    ->color('gray')
                    ->icon(Heroicon::Eye)
                    ->modalHeading('Patient Details')
                    ->modalWidth('2xl')
                    ->schema([
                        Section::make('Personal Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Full Name')
                                            ->icon(Heroicon::User),
                                        TextEntry::make('date_of_birth')
                                            ->label('Date of Birth')
                                            ->date()
                                            ->icon(Heroicon::OutlinedCalendar),
                                        TextEntry::make('marital_status')
                                            ->label('Marital Status')
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Single' => 'primary',
                                                'Married' => 'success',
                                                default => 'gray',
                                            })
                                            ->icon(Heroicon::Heart),
                                    ]),
                            ]),
                        
                        Section::make('Contact Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('email')
                                            ->label('Email Address')
                                            ->icon(Heroicon::Envelope)
                                            ->copyable(),
                                        TextEntry::make('phone_number')
                                            ->label('Phone Number')
                                            ->icon(Heroicon::Phone)
                                            ->copyable(),
                                        TextEntry::make('address')
                                            ->label('Address')
                                            ->icon(Heroicon::MapPin)
                                            ->prose(),
                                    ])
                            ]),

                        Section::make('System Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label('Registration Date')
                                            ->dateTime()
                                            ->icon(Heroicon::OutlinedCalendarDays),
                                        TextEntry::make('updated_at')
                                            ->label('Last Updated')
                                            ->dateTime()
                                            ->icon(Heroicon::ArrowPath),
                                    ]),
                            ])
                            ->collapsible()
                            ->collapsed(),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
