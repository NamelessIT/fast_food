<?php

namespace App\Filament\Widgets;

use App\Models\Account;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class Overview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        
        $start=$this->filters['startDate'];
        $end=$this->filters['endDate'];
        $active=$this->filters['active'];
        if($active===true){
            return [
                //               
                Stat::make('Tổng số đơn hàng',Bill::when($start,fn($query)=>$query->whereDate('created_at','>=',$start))
                ->when($end,fn($query)=>$query->whereDate('created_at','<=',$end))
                ->count())
                ->description('hoá đơn')
                ->descriptionIcon('heroicon-m-receipt-percent',IconPosition::Before)
                ->chart([10,15,20,30,40,70])
                ->color('info'),
                Stat::make('Số lượng khách hàng',Customer::when($start,fn($query)=>$query->whereDate('created_at','>=',$start))
                ->when($end,fn($query)=>$query->whereDate('created_at','<=',$end))
                ->count())
                ->description('khách hàng đã đăng ký')
                ->descriptionIcon('heroicon-m-user-group',IconPosition::Before)
                ->chart([10,15,20,30,40,70])
                ->color('danger'),
                Stat::make('Sản phẩm',Product::when($start,fn($query)=>$query->whereDate('created_at','>=',$start))
                ->when($end,fn($query)=>$query->whereDate('created_at','<=',$end))
                ->count())
                ->description('Sản phẩm hiện đang có')
                ->descriptionIcon('heroicon-m-shopping-cart',IconPosition::Before)
                ->chart([10,15,20,30,40,70])
                ->color('warning'),
                Stat::make('Tổng doanh thu',Bill::when($start,fn($query)=>$query->whereDate('created_at','>=',$start))
                ->when($end,fn($query)=>$query->whereDate('created_at','<=',$end)
                ->where("bills.status","=",2))
                ->sum("bills.total"))
                ->description('VNĐ')
                ->descriptionIcon('heroicon-m-banknotes',IconPosition::Before)
                ->chart([10,15,20,30,40,70])
                ->color('info'),
            ];
        }
        else{
            return [
                //               
                Stat::make('Tổng số đơn hàng',Bill::count())
                ->description('hoá đơn')
                ->descriptionIcon('heroicon-m-receipt-percent',IconPosition::Before)
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
                ->color('warning'),
                Stat::make('Tổng doanh thu',Bill::where("bills.status","=",2)
                ->sum("bills.total"))
                ->description('VNĐ')
                ->descriptionIcon('heroicon-m-banknotes',IconPosition::Before)
                ->chart([10,15,20,30,40,70])
                ->color('info'),
            ];
        }

    }
}
