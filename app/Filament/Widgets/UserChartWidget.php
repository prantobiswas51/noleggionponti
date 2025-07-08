<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Carbon\Carbon;

class UserChartWidget extends ChartWidget
{
    protected static ?string $heading = 'User Registrations (Last 7 Days)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get the date range for the last 7 days
        $dates = collect();
        $registrations = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates->push($date);

            // Count the registrations for the current date
            $count = User::whereDate('created_at', $date)->count();
            $registrations->push($count);
        }

        // Format the chart data
        $data = [
            'labels' => $dates->toArray(),
            'datasets' => [
                [
                    'label' => 'User Registrations',
                    'data' => $registrations->toArray(),
                    'borderColor' => 'rgba(75, 192, 192, 1)', // You can change the color
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Optional: to give a filled color below the line
                    'fill' => true, // Optional: to fill the area below the line
                    'lineTension' => 0.1, // Optional: Adjust line tension
                ],
            ],
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'line'; // This ensures the chart type is a line chart
    }
}
