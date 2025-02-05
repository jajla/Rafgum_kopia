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
            Stat::make('users' ,Visit::count())
        ->chart([1,2,3,40,5,6,7,8,9,10])
                ->description('sds')
                ->color('success'),
        ];
    }
}
