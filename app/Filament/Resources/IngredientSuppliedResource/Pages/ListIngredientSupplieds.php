<?php

namespace App\Filament\Resources\IngredientSuppliedResource\Pages;

use App\Filament\Resources\IngredientSuppliedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIngredientSupplieds extends ListRecords
{
    protected static string $resource = IngredientSuppliedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
