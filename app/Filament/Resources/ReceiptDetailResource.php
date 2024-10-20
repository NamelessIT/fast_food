<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptDetailResource\Pages;
use App\Filament\Resources\ReceiptDetailResource\RelationManagers;
use App\Models\ReceiptDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Receipt;
use App\Models\Ingredient;
class ReceiptDetailResource extends Resource
{
    protected static ?string $model = ReceiptDetail::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Select::make('id_receipt')
                ->label('Mã phiếu nhập')
                ->required()
                ->options(Receipt::pluck('id', 'id')->toArray())
                ->placeholder('Chọn phiếu nhập'),

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_receipt')->label('Mã phiếu nhập'),
                TextColumn::make('id_ingredient')->label('Tên nguyên liệu'),
                TextColumn::make('quantity')->label('Số lượng (Kg)'),
                TextColumn::make('total_price')->label('Tổng tiền (vnd)'),
                TextColumn::make('created_at')->label('Ngày tạo phiếu nhập'),
                TextColumn::make('updated_at')->label('Ngày cập nhật phiếu nhập'),
            ])
            ->defaultSort('id_receipt')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceiptDetails::route('/'),
            'create' => Pages\CreateReceiptDetail::route('/create'),
            'edit' => Pages\EditReceiptDetail::route('/{record}/edit'),
        ];
    }
}
