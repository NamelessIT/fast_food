<?php

namespace App\Filament\Resources\ExtraFoodResource\Pages;

use App\Filament\Resources\ExtraFoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtraFood extends ListRecords
{
    protected static string $resource = ExtraFoodResource::class;

    protected function getHeaderActions(): array
    {
       return [
            Actions\CreateAction::make(),
        ];
    }
}
