<?php

namespace App\Filament\Exports;

use App\Models\ExportCustomer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ExportCustomerExporter extends Exporter
{
    protected static ?string $model = ExportCustomer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make("Tên khách hàng"),
            ExportColumn::make("Hoá đơn"),
            ExportColumn::make("Chi tiêu"),
            ExportColumn::make("Ngày tạo"),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your export customer export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
