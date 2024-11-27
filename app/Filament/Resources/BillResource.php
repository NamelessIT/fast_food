<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use App\Models\Bill;
use App\Models\ExtraFood;
use Filament\Facades\Filament;
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
use Illuminate\Support\Facades\Auth;

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
                            ->relationship('extraFoods')
                            ->label('Món ăn thêm')
                            ->schema([
                                Select::make('id_extra_food')
                                    ->columnSpan(6)
                                    ->label('Tên món ăn thêm')
                                    ->relationship('extraFood', 'food_name')
                                    ->afterStateUpdated(function ($state, $set) {
                                        // Khi món ăn được chọn, lấy giá trị 'price' từ 'extraFood'
                                        $extraFood = ExtraFood::find($state);
                                        if ($extraFood) {
                                            $set('price', $extraFood->price); // Đặt giá trị 'price' từ 'extraFood'
                                        }
                                    }),

                                TextInput::make('quantity')
                                    ->columnSpan(2)
                                    ->label('Số lượng')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('price')
                                    ->columnSpan(3)
                                    ->label('Đơn giá')
                                    ->disabled(),


                                TextInput::make('extra_food_total')
                                    ->columnSpan(3)
                                    ->default(fn ($record) => ($record?->quantity ?? 0) * ($record?->extraFood?->price ?? 0)) // Tính thành tiền
                                    ->label('Thành tiền'),
                            ])
                            ->columns(14)
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
                    ->disabled(function ($record) {
                        return $record->status === 3 || $record->status === 0; // Disable khi trạng thái là "Đã giao" hoặc "Hủy"
                    })
                    ->options([
                        0 => 'Hủy',
                        1 => 'Đang chờ',
                        2 => 'Xác nhận',
                        3 => 'Đã giao',
                    ])
                    ->afterStateUpdated(function ($state, $record) {
                        $record->status = $state; // Cập nhật trạng thái trong cơ sở dữ liệu
                        $record->save(); // Lưu thay đổi vào cơ sở dữ liệu
                        // Chỉ cộng điểm khi trạng thái là "Đã giao" (3)
                        if ($state === 3) {
                            $record->customer->points += $record->point_receive;
                            $record->customer->save();
                        }
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
            ])->poll('10s')
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

    public static function canViewAny(): bool
    {
        // Lấy người dùng đang đăng nhập
        $user = Auth::user();
        //$user = auth()->user();

        if ($user->user->id_role==2) //nhân viên bình thường
            return true;
        if ($user->user->id_role==1)
            return false;
    }
}
