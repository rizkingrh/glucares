<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use App\Models\QrScan;
use App\Models\History;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Analytics';

    protected ?string $description = 'An overview of some analytics.';

    protected function getStats(): array
    {
        // Total Patients
        $totalPatients = Patient::count();

        // Total QR Scans
        $totalScans = QrScan::count();

        // Average Glucose Level
        $avgGlucose = History::avg('glucose_level');
        $avgGlucoseFormatted = $avgGlucose ? number_format($avgGlucose, 1) : 'N/A';

        // High Risk Percentage (assuming glucose > 200 mg/dL is high risk)
        $totalMeasurements = History::count();
        $highRiskCount = History::where('glucose_level', '>', 200)->count();
        $highRiskPercentage = $totalMeasurements > 0 ? number_format(($highRiskCount / $totalMeasurements) * 100, 1) : '0';

        return [
            Stat::make('Total Patients', number_format($totalPatients))
                ->description('Registered patients')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('Total QR Scanned', number_format($totalScans))
                ->description('QR codes scanned')
                ->descriptionIcon('heroicon-m-qr-code')
                ->color('success'),
            
            Stat::make('Average Glucose', $avgGlucoseFormatted)
                ->description('Average (mg/dL)')
                ->descriptionIcon('heroicon-m-heart')
                ->color('info'),
            
            Stat::make('High Risk Percentage', $highRiskPercentage . '%')
                ->description('High glucose')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
