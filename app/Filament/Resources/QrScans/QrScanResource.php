<?php

namespace App\Filament\Resources\QrScans;

use BackedEnum;
use App\Models\QrScan;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\QrScans\Pages\EditQrScan;
use App\Filament\Resources\QrScans\Pages\ViewQrScan;
use App\Filament\Resources\QrScans\Pages\ListQrScans;
use App\Filament\Resources\QrScans\Pages\QrScannerPage;
use App\Filament\Resources\QrScans\Pages\CreateQrScan;
use App\Filament\Resources\QrScans\Schemas\QrScanForm;
use App\Filament\Resources\QrScans\Tables\QrScansTable;
use App\Filament\Resources\QrScans\Schemas\QrScanInfolist;

class QrScanResource extends Resource
{
    protected static ?string $model = QrScan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQrCode;

    protected static ?string $navigationLabel = 'QR Scanner';
    protected static ?string $slug = 'qr-scans';

    protected static ?string $recordTitleAttribute = 'QrScan';

    public static function form(Schema $schema): Schema
    {
        return QrScanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return QrScanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QrScansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQrScans::route('/'),
            'create' => CreateQrScan::route('/create'),
            'view' => ViewQrScan::route('/{record}'),
            'edit' => EditQrScan::route('/{record}/edit'),
            'scanner' => QrScannerPage::route('/scanner'),
        ];
    }
}
