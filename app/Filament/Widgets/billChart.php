<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Bill;
use Carbon\Carbon;

class billChart extends ChartWidget
{
    protected static ?int $sort=3;
    protected static ?string $heading = 'Thống kê trạng thái đơn hàng';

    use InteractsWithPageFilters;

    protected function getData(): array
    {
        $name = $this->filters['name'] ??null;
        $start = $this->filters['startDate'] ?? now()->subMonth()->startOfMonth(); // Mặc định từ đầu tháng trước
        $end = $this->filters['endDate'] ?? now()->endOfMonth(); // Mặc định đến cuối tháng hiện tại
        $top = $this->filters['Range'] ?? null;
        $isDescrease = $this->filters['Descrease'] ?? false;
        $money = $this->filters['Money'] ?? false;

        if ($this->filters['active'] === true) {
            $billData = $this->getBillByStatusHasFilter($start, $end);
        } else {
            $billData = $this->getBillByStatus();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Số lượng hóa đơn',
                    'data' => array_values($billData),
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#4BC0C0', '#80ED99'], // Màu cho các phần của biểu đồ
                ],
            ],
            'labels' => ['Hủy hóa đơn', 'Đang chờ xác nhận', 'Đã xác nhận','Đã hoàn thành'], // Nhãn tương ứng với status
        ];
    }

    public function getBillByStatus(): array
    {
        return [
            0 => Bill::where('status', 0)->count(),
            1 => Bill::where('status', 1)->count(),
            2 => Bill::where('status', 2)->count(),
            3 => Bill::where('status', 3)->count(),
        ];
    }

    public function getBillByStatusHasFilter($start, $end): array
    {
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->endOfDay();

        return [
            0 => Bill::where('status', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            1 => Bill::where('status', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            2 => Bill::where('status', 2)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            3 => Bill::where('status', 3)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Biểu đồ hình tròn
    }
}
