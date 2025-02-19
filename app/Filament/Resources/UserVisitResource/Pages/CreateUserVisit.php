<?php

namespace App\Filament\Resources\UserVisitResource\Pages;

use App\Filament\Resources\UserVisitResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateUserVisit extends CreateRecord
{
    protected static string $resource = UserVisitResource::class;
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $date = Carbon::parse($data['date']);
        $time = $data['time'];
        return [
            'user_id' => auth()->id(),
            'date' => $date->format('Y-m-d'),
            'time' => $time,
            'service_type' => $data['service_type'],

        ];
    }
}
