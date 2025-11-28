<?php

namespace App\Filament\Widgets;

use App\Models\History;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistoriesChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Glucose Level Trends';

    public function getDescription(): ?string
    {
        return 'Average glucose levels over the last 12 months';
    }

    protected int | string | array $columnSpan = 'full'; 

    protected function getData(): array
    {
        // Get data for the last 12 months
        $data = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->startOfMonth()->toDateString();
            $monthEnd = $month->endOfMonth()->toDateString();
            
            $avgGlucose = History::whereBetween('created_at', [$monthStart, $monthEnd])
                ->avg('glucose_level');
            
            $data[] = $avgGlucose ? round($avgGlucose, 1) : 0;
            $labels[] = $month->format('M Y');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Average Glucose (mg/dL)',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => false,
                    'min' => 70,
                    'max' => 300,
                    'title' => [
                        'display' => true,
                        'text' => 'Glucose Level (mg/dL)'
                    ]
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
