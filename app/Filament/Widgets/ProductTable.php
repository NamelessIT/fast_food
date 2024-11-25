<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\ExportProductExporter;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

// php artisan make::filament-exporter name_file
class ProductTable extends BaseWidget
{
    use InteractsWithPageFilters;
    public function table(Table $table): Table
    {
        $active = $this->filters['active'] ?? false;
        $name = $this->filters['name'] ?? null;
        $start = $this->filters['startDate'] ?? now()->subMonth()->startOfMonth(); // Mặc định từ đầu tháng trước
        $end = $this->filters['endDate'] ?? now()->endOfMonth(); // Mặc định đến cuối tháng hiện tại
        $top = $this->filters['Range'] ?? null;
        $isDescrease = $this->filters['Descrease'] ?? false;
        $money = $this->filters['Money'] ?? false;
        ExportProductExporter::getActive_Money($this->filters??[]);
        return $table

            ->query(
                $this->getQuery($active, $start, $end, $top, $isDescrease, $money, $name)
            )
            ->columns([
                TextColumn::make('product_name')
                    ->label('Tên sản phẩm'),
                TextColumn::make('id_bill')
                ->label('Hóa đơn'),
                $active && $money
                ?
                TextColumn::make('total_price')
                ->label('Tổng tiền')
                ->money('VND') // Nếu bạn muốn hiển thị theo định dạng tiền tệ            
                :                
                TextColumn::make('quantity')
                ->label('Số lượng'),
                TextColumn::make('full_name')
                    ->label('Khách hàng'),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d-m-Y H:i'),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ExportProductExporter::class)
            ]) 
            ->bulkActions([
                ExportBulkAction::make()->exporter(ExportProductExporter::class),
            ])
            ;
    }
    public function getQuery($active=false,$start, $end, $top = null, $isDescrease = false, $money = false, $name = null){
        if($active===true){
            $query = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
            ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
            ->where('bills.status',"=",2)
            ->join('customers', 'customers.id', '=', 'bills.id_customer')
            ->select(
                'bill_details.id', // Thêm cột id vào đây
                'products.product_name',
                'bill_details.id_bill',
                'bill_details.quantity',
                DB::raw('bill_details.quantity * products.price as total_price'),
                'customers.full_name',
                'bill_details.created_at',
                
            )
            
            ->whereBetween('bill_details.created_at', [
                $start ? Carbon::parse($start)->startOfDay() : '0000-01-01',
                $end ? Carbon::parse($end)->endOfDay() : now(),
            ]);

        // Lọc theo tên sản phẩm nếu có
        if ($name) {
            $query->where('products.product_name', 'like', '%' . $name . '%');
        }


        // Thứ tự sắp xếp
        if ($isDescrease) {
            $query->orderBy('bill_details.created_at', 'asc');
        } else {
            $query->orderBy('bill_details.created_at', 'desc');
        }

        // Giới hạn số bản ghi nếu có `$top`
        if ($top) {
            $query->limit($top);
        }
        }
        else{
            $query = Product::join('bill_details', 'bill_details.id_product', '=', 'products.id')
            ->join('bills', 'bills.id', '=', 'bill_details.id_bill')
            ->where('bills.status',"=",2)
            ->join('customers', 'customers.id', '=', 'bills.id_customer')
            ->select(
                'bill_details.id', // Thêm cột id vào đây
                'products.product_name',
                'bill_details.id_bill',
                'bill_details.quantity',
                'customers.full_name',
                'bill_details.created_at'
            )
            ;
        }
    return $query;
    }
}
