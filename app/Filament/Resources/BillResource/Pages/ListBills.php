<?php

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBills extends ListRecords
{
    protected static string $resource = BillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
{
    return [
        'all' => Tab::make('All'),
        'pending' => Tab::make('Đang chờ')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)),
        'confirmed' => Tab::make('Đã xác nhận')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 2)),
        'delivered' => Tab::make('Đã giao')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 3)),
        'cancel' => Tab::make('Đã hủy')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 0)),
    ];
}
}
