<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// composer require flowframe/laravel-trend
class ChartProduct extends ChartWidget
{
    public $products=[];
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Thống kê sản phẩm được bán ra';

    protected function getData(): array
{
    $name=$this->filters['name']??null ;
    $start = $this->filters['startDate'] ?? now()->subMonth()->startOfMonth(); // Mặc định từ đầu tháng trước
    $end = $this->filters['endDate'] ?? now()->endOfMonth(); // Mặc định đến cuối tháng hiện tại
    $top = $this->filters['Range'] ?? null;
    $isDescrease = $this->filters['Descrease'] ?? false;
    $money = $this->filters['Money'] ?? false;

    if ($this->filters['active'] === true) {
        $this->getProductInBillByFilters($start, $end, $top, $isDescrease, $money,$name);

        $data = [];
        $labels = [];
        foreach ($this->products as $product) {
            $labels[] = $product->product_name; // Tên sản phẩm
            $data[] = $money ? $product->total_price : $product->quantity; // Theo giá hoặc số lượng
        }
        $backgroundColor = $this->generateColors(count($labels));
        return [
            'datasets' => [
                [
                    'label' => $money ? 'Doanh thu sản phẩm' : 'Sản phẩm bán được',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                ]
            ],
            'labels' => $labels,
        ];
    } else {
        $data = [];
        $labels = [];
        $this->getProductInBill();
        foreach ($this->products as $product) {
            $labels[] = $product->product_name; // Giả sử cột 'name' là tên sản phẩm
            $data[] = $product->quantity; // Giả sử cột 'quantity' là số lượng bán được
        }
        $backgroundColor = $this->generateColors(count($labels));
        return [
            'datasets' => [
                [
                    'label' => 'Sản phẩm bán được',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                ]
            ],
            'labels' => $labels,
        ];
    }
}

public function getProductInBillByFilters($start, $end, $top = null, $isDescrease = false, $money = false, $name = null)
{
    if ($start && $end && Carbon::parse($start)->gt(Carbon::parse($end))) {
        throw new \InvalidArgumentException('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.');
    }

    $query = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
        ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
        ->where('bills.status',"=",2)
        ->whereBetween('bills.created_at', [
            $start ? Carbon::parse($start)->startOfDay() : '0000-01-01',
            $end ? Carbon::parse($end)->endOfDay() : now(),
        ]);

    // Lọc theo tên sản phẩm nếu có
    if ($name) {
        $query->where('products.product_name', 'like', '%' . $name . '%');
    }

    if ($money) {
        $query->select(
            'products.product_name',
            DB::raw('SUM(bill_details.quantity * products.price) as total_price')
        );
    } else {
        $query->select(
            'products.product_name',
            DB::raw('SUM(bill_details.quantity) as quantity')
        );
    }

    $query->groupBy('products.product_name');

    if ($isDescrease) {
        $query->orderBy($money ? 'total_price' : 'quantity', 'asc');
    } else {
        $query->orderBy($money ? 'total_price' : 'quantity', 'desc');
    }

    if ($top) {
        $query->limit($top);
    }

    $this->products = $query->get();
}

    protected function generateColors($count): array
{
    $colors = [];
    for ($i = 0; $i < $count; $i++) {
        $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); 
    }
    return $colors;
}
    public function getProductInBill()
    {
        $this->products = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
            ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
            ->where("bills.status","=",2)
            ->select('products.product_name', DB::raw('SUM(bill_details.quantity) as quantity')) // Lấy tên sản phẩm và tổng số lượng bán
            ->groupBy('products.product_name') // Nhóm theo sản phẩm
            ->orderBy('quantity', 'desc')
            ->get();
    }



    protected function getType(): string
    {
        
        return 'bar';
    }
}
