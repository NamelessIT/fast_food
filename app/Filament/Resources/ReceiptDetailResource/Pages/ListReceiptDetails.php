<?php

namespace App\Filament\Resources\ReceiptDetailResource\Pages;

use App\Filament\Resources\ReceiptDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceiptDetails extends ListRecords
{
    protected static string $resource = ReceiptDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
