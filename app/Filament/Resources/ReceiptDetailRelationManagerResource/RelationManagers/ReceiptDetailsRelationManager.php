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
                ->label('Lượng  nhập')
                ->placeholder('Vui lòng nhập lượng nguyên liệu')
                ->numeric()
                ->rules('required|numeric|min:1')
                ->reactive()
                ->afterStateUpdated(function ($state, $set) { // Sửa đổi đây
                    if ($state === '') {
                        $set('Lượng nhập', ''); // Xóa giá trị nếu trường trống
                    }
                }),

                /*TextInput::make('getIngredient.')
                ->label('Tổng tiền (vnd)')
                ->numeric()
                ->rules('required|numeric|min:1')
                ->reactive()
                ->afterStateUpdated(function ($state, $set) { // Sửa đổi đây
                    if ($state === '') {
                        $set('Tổng tiền (vnd)', ''); // Xóa giá trị nếu trường trống
                    }
                }),*/

                TextInput::make('created_at')
                    ->label('Ngày tạo phiếu nhập')
                    ->default(Carbon::now()->format('Y-m-d'))
                    ->disabled(),

                TextInput::make('updated_at')
                    ->label('Ngày cập nhật phiếu nhập')
                    ->default(Carbon::now()->format('Y-m-d'))
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id_ingredient')
            ->columns([
               





                
                TextColumn::make('getIngredient.ingredient_name')
                    ->label('Nguyên liệu')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('quantity')
                    ->label('Lượng nhập')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('getIngredient.unit')
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
