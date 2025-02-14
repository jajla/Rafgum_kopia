<?php

namespace App;

use App\Models\Visit;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UserVisitService
{
    public function getAvailableTimesForDate(string $date): array
    {
        $date = Carbon::parse($date);
        $startPeriod = $date->copy()->hour(9);
        $endPeriod = $date->copy()->hour(18);
        $times = CarbonPeriod::create($startPeriod, '30 minutes', $endPeriod);

        $reservations = Visit::whereDate('date', $date)
            ->pluck('time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableReservations = [];
        foreach ($times as $time) {
            $formattedTime = $time->format('H:i');
            if (!in_array($formattedTime, $reservations)) {
                $availableReservations[$formattedTime] = $formattedTime;
            }
        }

        return $availableReservations;

    }
}
