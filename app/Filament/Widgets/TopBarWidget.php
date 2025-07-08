<?php

namespace App\Filament\Widgets;

use App\Models\Esp32Device;
use App\Models\Esp32Session;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class TopBarWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Registered Users', User::count()),
            Stat::make('Active Sessions', Esp32Session::where('active', true)->count()),
            Stat::make('Total Bridges', Esp32Device::count()),
            Stat::make('Total Payment', Transaction::sum('amount') . ' €'),
        ];
    }
}
