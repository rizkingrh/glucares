<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->icon('heroicon-o-user')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter patient\'s full name')
                                    ->columnSpan(2),
                                
                                DatePicker::make('date_of_birth')
                                    ->label('Date of Birth')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now())
                                    ->placeholder('Select birth date')
                                    ->columnSpan(1),
                                
                                Select::make('marital_status')
                                    ->label('Marital Status')
                                    ->required()
                                    ->options([
                                        'Single' => 'Single',
                                        'Married' => 'Married',
                                    ])
                                    ->placeholder('Select marital status')
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Contact Information')
                    ->icon('heroicon-o-phone')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('patient@example.com')
                                    ->prefixIcon('heroicon-o-envelope')
                                    ->columnSpan(1),
                                
                                TextInput::make('phone_number')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20)
                                    ->placeholder('08123456789')
                                    ->prefixIcon('heroicon-o-phone')
                                    ->columnSpan(1),
                                
                                Textarea::make('address')
                                    ->label('Address')
                                    ->required()
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->placeholder('Enter complete address including street, city, state, and zip code')
                                    ->columnSpan(2),
                            ]),
                    ]),

                // Section::make('Additional Notes')
                //     ->description('Optional additional information')
                //     ->icon('heroicon-o-document-text')
                //     ->collapsible()
                //     ->collapsed()
                //     ->schema([
                //         Textarea::make('notes')
                //             ->label('Medical Notes')
                //             ->rows(4)
                //             ->maxLength(1000)
                //             ->placeholder('Any additional medical information or notes...')
                //             ->helperText('This field is optional and can be used for medical history or special instructions.'),
                //     ]),
            ]);
    }
}
