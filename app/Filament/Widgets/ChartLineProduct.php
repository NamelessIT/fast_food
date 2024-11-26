<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartLineProduct extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort=2;
    protected static ?string $heading = 'Thống kê sản phẩm theo ngày';

    protected function getData(): array
    {
        $active=$this->filters['active']??false;
        $name = $this->filters['name'] ?? null;
        $start = $this->filters['startDate'] ?? now()->subMonth()->startOfMonth();
        $end = $this->filters['endDate'] ?? now()->endOfMonth();
        $money = $this->filters['Money'] ?? false;

        // Lấy dữ liệu sản phẩm theo ngày
        $active?
        $productsData = $this->getProductDataByDate($start, $end, $money, $name):
        $productsData = $this->getProductData();

        $labels = $this->getDateLabels($start, $end);
        $datasets = [];

        foreach ($productsData as $productName => $data) {
            $datasets[] = [
                'label' => $productName,
                'data' => $this->mapDataToLabels($data, $labels),
                'fill' => false, // Không tô bên dưới line
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
    public function getProductData(){
        $startDate = now()->subMonth()->startOfMonth(); // Bắt đầu từ đầu tháng trước
        $endDate = now()->endOfMonth(); // Kết thúc vào cuối tháng hiện tại
        $query = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
                ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
                ->where('bills.status', '=', 2)
                ->whereBetween('bills.created_at', [
                    $startDate,
                    $endDate,
                ])
                ->select(
                    'products.product_name',
                    DB::raw('DATE(bills.created_at) as date'),
                    DB::raw('SUM(bill_details.quantity) as quantity'),)
                ->groupBy('products.product_name', 'date')
                ->orderBy('date', 'asc');
                $results = $query->get();

                // Chuẩn bị dữ liệu theo cấu trúc [product_name => [date => value]]
                $data = [];
                foreach ($results as $row) {
                    $productName = $row->product_name;
                    $date = $row->date;
                    $value = $row->quantity;

                    $data[$productName][$date] = $value;
                }

                return $data;
    }

    private function getProductDataByDate($start, $end, $money, $name = null)
    {
            $query = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
                ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
                ->where('bills.status', '=', 2)
                ->whereBetween('bills.created_at', [
                    Carbon::parse($start)->startOfDay(),
                    Carbon::parse($end)->endOfDay(),
                ]);
    
            if ($name ) {
                $query->where('products.product_name', 'like', '%' . $name . '%');
            }
    
            if ($money) {
                $query->select(
                    'products.product_name',
                    DB::raw('DATE(bills.created_at) as date'),
                    DB::raw('SUM(bill_details.quantity * products.price) as total_price')
                );
            } else {
                $query->select(
                    'products.product_name',
                    DB::raw('DATE(bills.created_at) as date'),
                    DB::raw('SUM(bill_details.quantity) as quantity')
                );
            }
    
            $query->groupBy('products.product_name', 'date');



        $results = $query->get();

        // Chuẩn bị dữ liệu theo cấu trúc [product_name => [date => value]]
        $data = [];
        foreach ($results as $row) {
            $productName = $row->product_name;
            $date = $row->date;
            $value = $money ? $row->total_price : $row->quantity;

            $data[$productName][$date] = $value;
        }

        return $data;
    }

    private function getDateLabels($start, $end)
    {
        $dates = [];
        $current = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        while ($current->lte($endDate)) {
            $dates[] = $current->toDateString();
            $current->addDay();
        }

        return $dates;
    }

    private function mapDataToLabels($data, $labels)
    {
        return array_map(function ($label) use ($data) {
            return $data[$label] ?? 0; // Nếu không có dữ liệu cho ngày đó, trả về 0
        }, $labels);
    }



    protected function getType(): string
    {
        return 'line';
    }
}
