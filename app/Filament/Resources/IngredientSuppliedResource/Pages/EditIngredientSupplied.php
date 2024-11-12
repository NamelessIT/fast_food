<?php

namespace App\Filament\Resources\IngredientSuppliedResource\Pages;

use App\Filament\Resources\IngredientSuppliedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIngredientSupplied extends EditRecord
{
    protected static string $resource = IngredientSuppliedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
