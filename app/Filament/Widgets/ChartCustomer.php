<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartCustomer extends ChartWidget
{
    public $customers=[];
    protected static ?string $heading = 'Thống kê khách hàng';
    use InteractsWithPageFilters;

    protected function getData(): array
    {
        $name=$this->filters['name']??null ;
        $start = $this->filters['startDate'] ?? now()->subMonth()->startOfMonth(); // Mặc định từ đầu tháng trước
        $end = $this->filters['endDate'] ?? now()->endOfMonth(); // Mặc định đến cuối tháng hiện tại
        $top = $this->filters['Range'] ?? null;
        $isDescrease = $this->filters['Descrease'] ?? false;
        $money=$this->filters['Money']??false;
        if ($this->filters['active'] === true) {
            $this->getCustomerInBillHasFilter($start, $end, $top, $isDescrease, $name);

            $data = [];
            $labels = [];
            foreach ($this->customers as $customer) {
                $labels[] = $customer->full_name; 
                $data[] = $customer->total ; 
            }
            $backgroundColor = $this->generateColors(count($labels));
            return [
                'datasets' => [
                    [
                        'label' => 'Chi tiêu',
                        'data' => $data,
                        'backgroundColor' => $backgroundColor,
                    ]
                ],
                'labels' => $labels,
            ];
        }
        else{
            $data = [];
            $labels = [];
            $this->getCustomerInBill();
            foreach ($this->customers as $customer) {
                $labels[] = $customer->full_name; 
                $data[] = $customer->total;
            }
            $backgroundColor = $this->generateColors(count($labels));
            return [
                'datasets' => [
                    [
                        'label' => 'Chi tiêu',
                        'data' => $data,
                        'backgroundColor' => $backgroundColor,
                    ]
                ],
                'labels' => $labels,
            ];
        }
    }
    public function getCustomerInBillHasFilter($start, $end, $top = null, $isDescrease = false, $name = null)
{
    if ($start && $end && Carbon::parse($start)->gt(Carbon::parse($end))) {
        throw new \InvalidArgumentException('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.');
    }

    $query = Customer::join('bills', 'bills.id_customer', '=', 'customers.id')
        ->where("bills.status","=",2)
        ->select('customers.full_name', DB::raw('SUM(bills.total) as total')) // Lấy tên sản phẩm và tổng số lượng bán
        ->groupBy('customers.full_name') 
        ->orderBy('total', 'desc')
        ->whereBetween('bills.created_at', [
            $start ? Carbon::parse($start)->startOfDay() : '0000-01-01',
            $end ? Carbon::parse($end)->endOfDay() : now(),
        ]);

    // Lọc theo tên sản phẩm nếu có
    if ($name) {
        $query->where('customers.full_name', 'like', '%' . $name . '%');
    }

    if ($isDescrease) {
        $query->orderBy('total' , 'asc');
    } else {
        $query->orderBy('total' , 'desc');
    }

    if ($top) {
        $query->limit($top);
    }

    $this->customers = $query->get();
}

    protected function generateColors($count): array
{
    $colors = [];
    for ($i = 0; $i < $count; $i++) {
        $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); 
    }
    return $colors;
}
    public function getCustomerInBill()
    {
        $this->customers = Customer::join('bills', 'bills.id_customer', '=', 'customers.id')
            ->where("bills.status","=",2)
            ->select('customers.full_name', DB::raw('SUM(bills.total) as total'))
            ->groupBy('customers.full_name') 
            ->orderBy('total', 'desc')
            ->get();
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
