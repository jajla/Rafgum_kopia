<?php

namespace App;

use App\Models\Visit;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UserVisitService
{
    public function getAvailableTimesForDate(string $date): array
    {
        $date                  = Carbon::parse($date);
        $startPeriod           = $date->copy()->hour(9);
        $endPeriod             = $date->copy()->hour(18);
        $times                 = CarbonPeriod::create($startPeriod, '30 minutes', $endPeriod);
        $availableReservations = [];

        $reservations = Visit::whereDate('date', $date)
            ->pluck('time')
            ->toArray();

       $availableTimes = $times->filter(function ($time) use ($reservations) {
            return ! in_array($time, $reservations);
        })->toArray();

        foreach ($availableTimes as $time) {
            $key                         = $time->format('H:i');
            $availableReservations[$key] = $time->format('H:i');
        }
       // return $availableReservations;
    dump($times);
        dd($reservations);
    }
}
