<?php

namespace App\Filament\Widgets;

use App\Models\History;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RiskCategoryChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Risk Category Trends';

    public function getDescription(): ?string
    {
        return 'Patient distribution by glucose risk categories over time';
    }

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get data for the last 6 months
        $normalData = [];
        $highData = [];
        $veryHighData = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->startOfMonth()->toDateString();
            $monthEnd = $month->endOfMonth()->toDateString();

            // Count patients by risk category for this month
            $normal = History::whereBetween('created_at', [$monthStart, $monthEnd])
                ->whereBetween('glucose_level', [70, 140])
                ->distinct('patient_id')
                ->count('patient_id');

            $high = History::whereBetween('created_at', [$monthStart, $monthEnd])
                ->whereBetween('glucose_level', [141, 200])
                ->distinct('patient_id')
                ->count('patient_id');

            $veryHigh = History::whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('glucose_level', '>', 200)
                ->distinct('patient_id')
                ->count('patient_id');

            $normalData[] = $normal;
            $highData[] = $high;
            $veryHighData[] = $veryHigh;
            $labels[] = $month->format('M Y');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Normal (70-140 mg/dL)',
                    'data' => $normalData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.7)',
                    'borderColor' => '#22c55e',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'High (141-200 mg/dL)',
                    'data' => $highData,
                    'backgroundColor' => 'rgba(251, 146, 60, 0.7)',
                    'borderColor' => '#fb923c',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Very High (>200 mg/dL)',
                    'data' => $veryHighData,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.7)',
                    'borderColor' => '#ef4444',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'scales' => [
                'x' => [
                    'stacked' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Month'
                    ]
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Patients'
                    ]
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }
}