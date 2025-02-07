<?php

namespace App\Filament\Widgets;

use App\Enums\Role;
use App\Models\User;
use App\Models\Visit;
use App\Policies\UserPolicy;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\IFTTTHandler;


class UserWidget extends BaseWidget
{
    public static function canView(): bool
    {
        if (auth()->user()->role === Role::Admin) {
            return true;
        } else {
            return false;
        }
    }


    protected function getStats(): array
    {
        return [
            Stat::make('users', User::count()),
            Stat::make('visit', Visit::where('date', now()->toDateString())->count())
        ];
    }
}
