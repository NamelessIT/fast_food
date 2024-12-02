<?php

namespace App\Filament\Resources\ReceiptDetailRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\Ingredient;
use Filament\Tables\Columns\TextColumn;
use App\Models\ReceiptDetail;
use App\Models\IngredientSupplied;
use Illuminate\Support\Facades\Log;

class ReceiptDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'receiptDetails';// Tên quan hệ trong model Receipt

    protected static ?string $recordTitleAttribute = 'id_receipt';  // Hiển thị cột 'id_receipt' làm tiêu đề nếu cần

    protected static function afterSave($record)
    {
        // Nếu Receipt tồn tại, cập nhật tổng giá trị (total)
        if ($record->receipt) {
            $record->receipt->updateQuietly(); // Tránh vòng lặp do gọi sự kiện
        }
    }

    protected static function afterDelete($record)
    {
        if ($record->receipt) {
            $record->receipt->updateTotal(); // Cập nhật tổng total của Receipt
        }
    }

    public function form(Form $form): Form
    {
        return $form
                ->schema([
            Select::make('id_ingredient')
                ->label('Tên nguyên liệu')
                ->required()
                ->options(Ingredient::pluck('ingredient_name', 'id')->toArray())
                ->placeholder('Chọn nguyên liệu')
                ->reactive(),

            TextInput::make('quantity')
                ->required()
                ->label('Lượng nhập')
                ->placeholder('Vui lòng nhập lượng nguyên liệu')
                ->numeric()
                ->rules('required|numeric|min:1')
                ->reactive()
                ->afterStateUpdated(function ($state, $set, $get) {
                    $this->updateTotalPrice($set, $get);
                }),

            TextInput::make('total_price')
                ->label('Tổng tiền (vnd)')
                ->readonly() // Chỉ hiển thị, không chỉnh sửa được
                ->numeric()
                ->rules('numeric|min:0'),


                ]);
        }
      
    private function updateTotalPrice($set, $get)
    {
        // Lấy mã nguyên liệu từ state
        $ingredientId = $get('id_ingredient');
        $ingredientPrice = 0;
        // Kiểm tra nếu id_ingredient tồn tại, lấy giá nguyên liệu
        if ($ingredientId) {
            // Lấy giá nguyên liệu từ bảng ingredient_supplied
            $ingredientSupplied = IngredientSupplied::where('id_ingredient', $ingredientId)->first();
            if ($ingredientSupplied) {
                $ingredientPrice = $ingredientSupplied->ingredient_price ?? 0;
            } else {
                dd('IngredientSupplied không tìm thấy');
            }
        }
        // Tính toán tổng giá
        $quantity = floatval($get('quantity'));
        $totalPrice = $ingredientPrice * $quantity;
        //dd($totalPrice);
        // Set giá trị total_price
        $set('total_price', $totalPrice);
        
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id_ingredient')
            ->columns([
                TextColumn::make('IngredientSupplied.ingredient_price')
                    ->label('Đơn giá')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ingredient.ingredient_name')
                    ->label('Nguyên liệu')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('quantity')
                    ->label('Lượng nhập')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ingredient.unit')
                    ->label('Đơn vị')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('total_price')
                    ->label('Tổng tiền')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Ngày tạo phiếu')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Ngày cập nhật phiếu')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->defaultSort('id_ingredient', 'desc') // Sắp xếp theo 'created_at' thay vì 'id'
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
