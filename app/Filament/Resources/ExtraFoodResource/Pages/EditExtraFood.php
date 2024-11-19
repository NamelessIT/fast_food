<?php

namespace App\Filament\Resources\ExtraFoodResource\Pages;

use App\Filament\Resources\ExtraFoodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtraFood extends EditRecord
{
    protected static string $resource = ExtraFoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
