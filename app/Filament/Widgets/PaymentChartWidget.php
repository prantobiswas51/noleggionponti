<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PaymentChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Payments Over Time (Last 7 Days)';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Get the total payments for each day over the last 7 days
        $payments = Transaction::selectRaw('SUM(amount) as total, DATE(created_at) as date')
            ->where('created_at', '>=', Carbon::now()->subDays(7)) // Filter for the last 7 days
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare data for the chart
        $paymentData = $payments->mapWithKeys(function ($payment) {
            return [$payment->date => $payment->total];
        });

        // Generate the last 7 days' dates
        $dates = [];
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dates[] = Carbon::now()->subDays($i)->format('M d'); // Format the date for the chart label
            $weeklyData[] = $paymentData[$date] ?? 0;  // Default to 0 if no payment for that day
        }

        return [
            'datasets' => [
                [
                    'label' => 'Payments per Day',
                    'data' => $weeklyData,  // Payment data for the last 7 days
                ],
            ],
            'labels' => $dates,  // Labels for each of the last 7 days
        ];
    }

    protected function getType(): string
    {
        return 'line';  // You can change this to 'bar' if you prefer a bar chart
    }
}
