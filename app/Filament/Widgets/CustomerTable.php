<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\ExportCustomerExporter;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Customer;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
class CustomerTable extends BaseWidget
{
    protected static ?int $sort=4;

    use InteractsWithPageFilters;
    protected static bool $isLazy = false;
    public function table(Table $table): Table
    {

        $active = $this->filters['active'] ?? false;
        $name = $this->filters['name'] ?? null;
        $start = $this->filters['startDate'] ?? now()->subMonth()->startOfMonth(); // Mặc định từ đầu tháng trước
        $end = $this->filters['endDate'] ?? now()->endOfMonth(); // Mặc định đến cuối tháng hiện tại
        $top = $this->filters['Range'] ?? null;
        $isDescrease = $this->filters['Descrease'] ?? false;
        return $table
        ->query(
            $this->getQuery($active, $start, $end, $top, $isDescrease,  $name)
        )
        ->columns([
            TextColumn::make('full_name')
                ->label('Tên khách hàng'),
            TextColumn::make('id')
            ->label('Hóa đơn'),
            TextColumn::make('total')
            ->label('Chi tiêu'),
            TextColumn::make('date')
                ->label('Ngày tạo')
                ->dateTime('d-m-Y H:i'),
        ])
        ->headerActions([
            ExportAction::make()->exporter(ExportCustomerExporter::class)
        ])
        ->bulkActions([
            ExportBulkAction::make()->exporter(ExportCustomerExporter::class),
        ])
        ;
    }

    public function getQuery($active=false,$start, $end, $top = null, $isDescrease = false, $name = null){
        if($active===true){
            $query = Customer::join('bills', 'bills.id_customer', '=', 'customers.id')
            ->where("bills.status","=",3)
            ->select(
                'customers.id',
                    'bills.id',
                    'customers.full_name',
                    'bills.total',
                    'bills.created_at as date',) // Lấy tên sản phẩm và tổng số lượng bán
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
        }
        else{
            $query = Customer::join('bills', 'bills.id_customer', '=', 'customers.id')
            ->where("bills.status","=",3)
            ->select(
                'customers.id',
                'bills.id',
                'customers.full_name',
                'bills.total',
                'bills.created_at as date',)
            ->orderBy('total', 'desc');
        }
    return $query;
    }
}
