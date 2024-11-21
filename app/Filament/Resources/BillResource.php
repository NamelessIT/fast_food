<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use App\Models\Bill;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('id_customer')
                    ->label('Khách hàng')
                    ->relationship('customer', 'full_name')
                    ->markAsRequired(),

                Select::make('id_address')
                    ->label('Địa chỉ')
                    ->relationship('address', 'address'),

                Select::make('id_payment')
                    ->label('Phương thức thanh toán')
                    ->relationship('payment', 'payment_name')
                    ->markAsRequired(),

                Select::make('id_voucher')
                    ->label('Voucher')
                    ->relationship('voucher', 'voucher_name')
                    ->nullable(),

                TextInput::make('point_receive')
                    ->label('Điểm nhận được')
                    ->numeric()
                    ->nullable(),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        0 => 'Hủy',
                        1 => 'Đang chờ',
                        2 => 'Xác nhận',
                        3 => 'Đã giao',
                    ])
                    ->afterStateUpdated(function ($state, $record) {
                        $record->status = $state; // Cập nhật trạng thái trong cơ sở dữ liệu
                        $record->save(); // Lưu thay đổi vào cơ sở dữ liệu
                    }),
                TextInput::make('total')
                    ->label('Tổng tiền')
                    ->numeric(),
                Repeater::make('billDetails')
                    ->label('Chi tiết hóa đơn')
                    ->relationship()
                    ->schema([
                        Select::make('id_product')
                            ->label('Sản phẩm')
                            ->columnSpan(6)
                            ->relationship('product', 'product_name')
                            ->required(),

                        TextInput::make('quantity')
                            ->label('Số lượng')
                            ->columnSpan(2)
                            ->numeric()
                            ->required(),

                        // Hiển thị đơn giá từ Product
                        TextInput::make('product_price')
                            ->label('Đơn giá')
                            ->columnSpan(3)
                            //->disabled()
                            ->default(fn ($record) => $record?->product_price),
                        TextInput::make('total_price')
                            ->label('Thành tiền')
                            ->columnSpan(3)
                            //->disabled()
                            ->default(fn ($record) => $record?->total_price ?? 0),

                                // Thêm món ăn kèm cho từng sản phẩm
                        Repeater::make('extraFoods')
                            ->label('Món ăn kèm')
                            ->schema([
                                Select::make('id_extra_food')
                                    ->label('Món ăn thêm')
                                    ->relationship('extraFood', 'food_name')
                                    ->required(),

                                TextInput::make('quantity')
                                    ->label('Số lượng')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(14)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')
                    ->label('Mã đơn')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('customer.full_name')
                    ->label('Khách hàng')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('address.address')
                    ->label('Địa chỉ'),

                TextColumn::make('total')
                    ->label('Tổng tiền')
                    ->money('VND', true) // Hiển thị dưới dạng tiền tệ
                    ->sortable(),

                SelectColumn::make('status')
                    ->label('Trạng thái')
                    ->sortable()
                    ->options([
                        0 => 'Hủy',
                        1 => 'Đang chờ',
                        2 => 'Xác nhận',
                        3 => 'Đã giao',
                    ])
                    ->afterStateUpdated(function ($state, $record) {
                        $record->status = $state; // Cập nhật trạng thái trong cơ sở dữ liệu
                        $record->save(); // Lưu thay đổi vào cơ sở dữ liệu
                    }),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
/*                 TextColumn::make('billDetails')
                    ->label('Chi tiết hóa đơn')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->billDetails->map(function ($detail) {
                            return $detail->product->product_name . ' (' . $detail->quantity . ')';
                        })->implode(', ');
                    }) */
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBills::route('/'),
            //'create' => Pages\CreateBill::route('/create'),
            //'view' => Pages\ViewBill::route('/{record}'),
            //'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
