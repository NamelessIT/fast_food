<?php

namespace App\Filament\Resources\ReceiptDetailResource\Pages;

use App\Filament\Resources\ReceiptDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceiptDetail extends EditRecord
{
    protected static string $resource = ReceiptDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
