<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Filament\Resources\VoucherResource\RelationManagers;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;
    //protected static ?string $label = "Khuyến mãi";
    protected static ?string $pluralLabel = 'Khuyến mãi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('voucher_name')
                    ->label('Tên Voucher')
                    ->rules([
                        'required',
                    ])
                    ->validationMessages([
                        'required'  => 'Hãy nhập tên voucher',
                    ])
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Mô tả')
                    ->maxLength(500),

                TextInput::make('discount_percent')
                    ->label('Phần trăm giảm giá')
                    ->numeric()
                    ->rules([
                        'required',
                        'numeric',     // Kiểm tra giá trị là kiểu số
                        'min:0',        // Kiểm tra giá trị không nhỏ hơn 0
                        'max:100',      // Kiểm tra giá trị không lớn hơn 100
                    ])
                    ->validationMessages([
                        'required'  => 'hãy nhập phần trăm giảm',
                        'max' => 'Phần trăm giảm giá không được lớn hơn 100',
                        'min.' => 'Phần trăm giảm giá phải từ 0 đến 100',
                        'numeric' => 'Vui lòng nhập một số hợp lệ',  // Thông báo tùy chỉnh cho trường hợp không phải là số
                    ])
                    ->suffix('%'),

                TextInput::make('minium_condition')
                    ->label('Điều kiện tối thiểu')
                    ->numeric()
                    ->prefix('VNĐ'),

                DatePicker::make('start_date')
                    ->label('Ngày bắt đầu'),

                DatePicker::make('end_date')
                    ->label('Ngày kết thúc')
                    ->afterOrEqual('start_date')
                    ->validationMessages([
                        'after_or_equal' => 'ngày kết thúc phải sau hoặc trùng với ngày bắt đầu',
                    ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('voucher_name')
                    ->label('Tên Voucher')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(50),

                Tables\Columns\TextColumn::make('discount_percent')
                    ->label('Giảm giá')
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\TextColumn::make('minium_condition')
                    ->label('Điều kiện tối thiểu')
                    ->money('VND')
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Ngày bắt đầu')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Ngày kết thúc')
                    ->date('d/m/Y')
                    ->sortable(),
                ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
                Filter::make('trashed')
                    ->label('Hiển thị món đã xóa')
                    ->form([
                        Checkbox::make('trashed')  // Tạo một checkbox để chọn lọc
                            ->label('Voucher đã xóa')
                            ->default(false),  // Mặc định là chưa chọn
                    ])
                    ->query(function ($query, $data) {
                        if ($data['trashed']) {
                            return $query->onlyTrashed();  // Hiển thị món đã xóa
                        }

                        return $query->whereNull('deleted_at');  // Hiển thị món chưa xóa
                    }),
                Tables\Filters\Filter::make('active')
                    ->default(true)
                    ->label('Voucher đang hoạt động')  // Nhãn bộ lọc
                    ->query(fn (Builder $query) => $query->where('start_date', '<=', now())  // Voucher có start_date <= hiện tại
                                                          ->where('end_date', '>=', now())), // Voucher có end_date >= hiện tại

                Tables\Filters\Filter::make('non-active')
                    ->default(false)
                    ->label('Voucher không có hiệu lực')  // Nhãn bộ lọc
                    ->query(fn (Builder $query) => $query->where('start_date', '>', now())
                                                          ->orwhere('end_date', '<', now())),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    //Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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
