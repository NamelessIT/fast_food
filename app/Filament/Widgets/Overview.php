<?php

namespace App\Filament\Widgets;

use App\Models\Account;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Overview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Tổng số đơn hàng',Bill::count())
            ->description('hoá đơn')
            ->descriptionIcon('heroicon-m-banknotes',IconPosition::Before)
            ->chart([10,15,20,30,40,70])
            ->color('info'),
            Stat::make('Số lượng khách hàng',Customer::count())
            ->description('khách hàng đã đăng ký')
            ->descriptionIcon('heroicon-m-user-group',IconPosition::Before)
            ->chart([10,15,20,30,40,70])
            ->color('danger'),
            Stat::make('Sản phẩm',Product::count())
            ->description('Sản phẩm hiện đang có')
            ->descriptionIcon('heroicon-m-shopping-cart',IconPosition::Before)
            ->chart([10,15,20,30,40,70])
            ->color('warning')
        ];
    }
}
