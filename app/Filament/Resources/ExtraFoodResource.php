<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtraFoodResource\Pages;
use App\Models\ExtraFood;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ExtraFoodResource extends Resource
{
    protected static ?string $model = ExtraFood::class;
    //protected static ?string $label = "Khuyến mãi";
    protected static ?string $pluralLabel = 'Món ăn thêm';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('food_name')
                    ->label('Tên món thêm')
                    ->rules([
                        'required',
                    ])
                    ->validationMessages([
                        'required'  => 'hãy nhập tên',
                    ]),

                TextInput::make('price')
                    ->label('Price')
                    ->prefix('VNĐ')
                    ->numeric()
                    ->rules([
                        'required',
                        'numeric',     // Kiểm tra giá trị là kiểu số
                        'min:0',
                    ])
                    ->validationMessages([
                        'min' => 'giá không là số âm',
                        'required'  => 'hãy nhập giá',
                        'numeric' => 'Vui lòng nhập một số hợp lệ',  // Thông báo tùy chỉnh cho trường hợp không phải là số
                    ]),

                TextInput::make('cod_price')
                    ->label('COD Price')
                    ->numeric()
                    ->prefix('VNĐ')
                    ->numeric()
                    ->rules([
                        'min:0',
                        'required',
                        'numeric',     // Kiểm tra giá trị là kiểu số
                    ])
                    ->validationMessages([
                        'min' => 'giá không là số âm',
                        'required'  => 'hãy nhập giá',
                        'numeric' => 'Vui lòng nhập một số hợp lệ',  // Thông báo tùy chỉnh cho trường hợp không phải là số
                    ]),

                TextInput::make('quantity')
                    ->label('Số lượng')
                    ->numeric()
                    ->default(0)
                    ->rules([
                        'min:0',
                        'required',
                        'numeric',     // Kiểm tra giá trị là kiểu số
                    ])
                    ->validationMessages([
                        'min' => 'giá không là số âm',
                        'required'  => 'hãy nhập số lượng',
                        'numeric' => 'Vui lòng nhập một số hợp lệ',  // Thông báo tùy chỉnh cho trường hợp không phải là số
                    ]),

                View::make('image_show')
                    ->label('Current Image')
                    ->view('filament.show-image', [
                        'imageBase64' => optional($form->getRecord())->image_show,  // Tránh lỗi khi bản ghi là null
                    ]),

                FileUpload::make('image_file')
                    ->label('Upload/Change Image')
                    ->directory('images')  // Chỉ định thư mục lưu trữ tạm thời
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            // Đọc file và chuyển thành Base64
                            $imageData = file_get_contents($state->getRealPath());
                            $imageBase64 = base64_encode($imageData);

                            // Lưu Base64 vào cột image_show trong cơ sở dữ liệu
                            $set('image_show', '' . $imageBase64);

                            // Xóa file tạm sau khi chuyển đổi sang Base64
                            unlink($state->getRealPath());
                        }
                    }),

                Hidden::make('image_show')
                    ->default(function ($record) {
                        // Kiểm tra bản ghi có tồn tại và có ảnh không
                        return optional($record)->image_show; // Tránh lỗi khi bản ghi là null
                }),

/*                 Repeater::make('Danh mục')
                    ->addActionLabel('Thêm danh mục')
                    ->schema([
                        Select::make('category_id')
                        ->label('Danh mục')
                        ->relationship('categories','category_name') // Chọn danh mục
                        ->preload() // Nạp trước toàn bộ danh mục
                        ->searchable(),
                ]), */

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('food_name')
                    ->label('Tên món')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Giá')
                    ->sortable()
                    ->searchable()
                    //->money('VNĐ'),  // Hiển thị dưới dạng tiền tệ
                    ,
                TextColumn::make('cod_price')
                    ->label('COD Price')
                    ->sortable()
                    ->searchable()
                    //->money('VNĐ'),  // Hiển thị dưới dạng tiền tệ
                    ,
                TextColumn::make('quantity')
                    ->label('Số lượng')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('image_show')
                    ->label('Image')
                    ->formatStateUsing(fn($state) => "<img src='data:image/jpeg;base64,{$state}' style='width: 100px; height: 100px; object-fit: cover;' />")
                    ->html(),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
                Filter::make('trashed')
                    ->label('Hiển thị món đã xóa')
                    ->form([
                        Checkbox::make('trashed')  // Tạo một checkbox để chọn lọc
                            ->label('Món đã xóa')
                            ->default(false),  // Mặc định là chưa chọn
                    ])
                    ->query(function ($query, $data) {
                        if ($data['trashed']) {
                            return $query->onlyTrashed();  // Hiển thị món đã xóa
                        }

                        return $query->whereNull('deleted_at');  // Hiển thị món chưa xóa
                    }), // Kiểm tra xem trường 'deleted_at' có giá trị hay không
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
            'index' => Pages\ListExtraFood::route('/'),
            'create' => Pages\CreateExtraFood::route('/create'),
            'edit' => Pages\EditExtraFood::route('/{record}/edit'),
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
