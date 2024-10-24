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
class ReceiptDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'receiptDetails';// Tên quan hệ trong model Receipt

    protected static ?string $recordTitleAttribute = 'id_receipt';  // Hiển thị cột 'id_receipt' làm tiêu đề nếu cần

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('id_ingredient')
                ->label('Tên nguyên liệu')
                ->required()
                ->options(Ingredient::pluck('ingredient_name', 'id')->toArray())
                ->placeholder('Chọn nguyên liệu'),

                
                TextInput::make('quantity')
                ->required()
                ->label('Số lượng (Kg)')
                ->placeholder('Vui lòng nhập số lượng nhập')
                ->numeric()
                ->rules('required|numeric|min:1')
                ->reactive()
                ->afterStateUpdated(function ($state, $set) { // Sửa đổi đây
                    if ($state === '') {
                        $set('Số lượng (Kg)', ''); // Xóa giá trị nếu trường trống
                    }
                }),

                TextInput::make('total_price')
                ->label('Tổng tiền (vnd)')
                ->numeric()
                ->rules('required|numeric|min:1')
                ->reactive()
                ->afterStateUpdated(function ($state, $set) { // Sửa đổi đây
                    if ($state === '') {
                        $set('Số lượng (Kg)', ''); // Xóa giá trị nếu trường trống
                    }
                }),

                TextInput::make('created_at')
                ->label('Ngày tạo phiếu nhập')
                ->default(Carbon::now()->format('Y-m-d H:i:s'))
                ->readOnlyOn('create'), // Set current date and time

                TextInput::make('updated_at')
                ->label('Ngày cập nhật phiếu nhập')
                ->default(Carbon::now()->format('Y-m-d H:i:s'))
                ->readOnlyOn('create'), // Set current date and time
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id_ingredient')
            ->columns([
                TextColumn::make('id_receipt')->label('Mã phiếu nhập'),
                TextColumn::make('ingredient.ingredient_name')->label('Tên nguyên liệu'),
                TextColumn::make('quantity')->label('Số lượng (Kg)'),
                TextColumn::make('total_price')->label('Tổng tiền (vnd)'),
                TextColumn::make('created_at')->label('Ngày tạo phiếu nhập'),
                TextColumn::make('updated_at')->label('Ngày cập nhật phiếu nhập'),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
