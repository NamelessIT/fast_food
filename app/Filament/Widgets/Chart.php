<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;
// composer require flowframe/laravel-trend
class Chart extends ChartWidget
{
    public $products=[];
    protected static ?string $heading = 'Thống kê sản phẩm được bán ra';
    protected int | string | array $columnSpan=1;

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $this->getProductInBill(); 
        foreach ($this->products as $product) {
            $labels[] = $product->product_name; // Giả sử cột 'name' là tên sản phẩm
            $data[] = $product->quantity; // Giả sử cột 'quantity' là số lượng bán được
        }
        $backgroundColor = $this->generateColors(count($labels));
        return [
            'datasets'=>[
                [
                    'label'=>'Sản phẩm bán được',
                    'data'=>$data,
                    'backgroundColor' => $backgroundColor, 
                ]
                ],
            'labels'=>$labels,
        ];
    }
    // protected function getData(): array
    // {
    //     $data = [];
    //     $data=Trend::model(Product::class)
    //     ->between(
    //         start:now()->subYear(),
    //         end:now(),
    //     )
    //     ->perMonth()
    //     ->count();
    //     $labels = [];
    //     $this->getProductInBill(); 
    //     foreach ($this->products as $product) {
    //         $labels[] = $product->product_name; // Giả sử cột 'name' là tên sản phẩm
    //         $data[] = $product->quantity; // Giả sử cột 'quantity' là số lượng bán được
    //     }
    //     $backgroundColor = $this->generateColors(count($labels));
    //     return [
    //         'datasets'=>[
    //             [
    //                 'label'=>'Sản phẩm bán được',
    //                 'data'=>$data->map(fn (TrendValue $value)=>$value->aggregate),
    //                 'backgroundColor' => $backgroundColor, 
    //             ]
    //             ],
    //         'labels'=>$labels,
    //     ];
    // }
    protected function generateColors($count): array
{
    $colors = [];
    for ($i = 0; $i < $count; $i++) {
        $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Tạo màu ngẫu nhiên
    }
    return $colors;
}
    public function getProductInBill()
    {
        $this->products = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
            ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
            ->select('products.product_name', DB::raw('SUM(bill_details.quantity) as quantity')) // Lấy tên sản phẩm và tổng số lượng bán
            ->groupBy('products.product_name') // Nhóm theo sản phẩm
            ->get();
    }
    

    protected function getType(): string
    {
        return 'bar';
    }
}
