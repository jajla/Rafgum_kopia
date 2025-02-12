<?php

namespace App\Filament\Resources\UserVisitResource\Pages;

use App\Filament\Resources\UserVisitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserVisit extends EditRecord
{
    protected static string $resource = UserVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
