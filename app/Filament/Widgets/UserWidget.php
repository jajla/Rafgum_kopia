<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Visit;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class UserWidget extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('users', User::count()),
            Stat::make('visit', Visit::where('date', now()->toDateString())->count())
        ];
    }
}
