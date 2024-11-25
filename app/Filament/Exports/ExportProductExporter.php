<?php

namespace App\Filament\Exports;

use App\Models\ExportProduct;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ExportProductExporter extends Exporter
{
    protected static ?string $model = ExportProduct::class;
    use InteractsWithPageFilters;
    protected static bool $export_active = false;
    protected static bool $export_money= false;

    public static function getActive_Money(array $filters)
    {
        static::$export_active = $filters['active'] ?? false;
        static::$export_money = $filters['Money'] ?? false;
    }
    public static function getColumns(): array
    {
        if(static::$export_active && static::$export_money){
            return [
                ExportColumn::make("Tên sản phẩm"),
                ExportColumn::make("Hoá đơn"),
                ExportColumn::make("Tổng tiền"),
                ExportColumn::make("Khách hàng"),
                ExportColumn::make("Ngày tạo"),
            ];
        }
        else{
            return [
                ExportColumn::make("Tên sản phẩm"),
                ExportColumn::make("Hoá đơn"),
                ExportColumn::make("Số lượng"),
                ExportColumn::make("Khách hàng"),
                ExportColumn::make("Ngày tạo"),
            ];
        }
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your export product export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
