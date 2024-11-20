<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $pluralLabel = 'Loại sản phẩm (Category)'; //label cho resource

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Trường 'category_name' và cập nhật 'slug'
                TextInput::make('category_name')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),

                // Trường mô tả
                TextInput::make('description'),

                // Trường trạng thái
                Checkbox::make('status')
                    ->default(true),

                // Hiển thị ảnh nếu có bản ghi, tránh lỗi khi không có bản ghi
                View::make('image')
                    ->label('Current Image')
                    ->view('filament.show-image', [
                        // Sử dụng optional để tránh lỗi khi bản ghi là null
                        'imageBase64' => optional($form->getRecord())->image,
                    ]),

                // Trường tải ảnh mới và chuyển sang Base64
                FileUpload::make('image_file')
                ->label('Upload/Change Image')
                ->directory('images')  // Thư mục lưu trữ tạm
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        // Đọc file và chuyển thành Base64
                        $imageData = file_get_contents($state->getRealPath());
                        $imageBase64 = base64_encode($imageData);

                        // Lưu Base64 vào cột image trong cơ sở dữ liệu
                        $set('image', $imageBase64);

                        // Xóa file tạm sau khi chuyển đổi sang Base64
                        unlink($state->getRealPath());
                    }
                }),




                // Trường ẩn 'image' lưu giá trị Base64 ảnh
                Hidden::make('image')
                    ->default(function ($record) {
                        // Kiểm tra bản ghi có tồn tại và có ảnh không
                        return $record && isset($record->image) ? $record->image : null;
                    }),

                // Trường ẩn 'slug'
                Hidden::make('slug'),

                Forms\Components\Repeater::make('extra_food')
                    ->relationship('extraFoodDetails')
                    ->label('Món gọi thêm')
                    ->addActionLabel('Thêm món gọi thêm')
                    ->columnSpanFull()
                    ->grid(2)
                    ->defaultItems(0)
                    ->schema([

                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_name'),
                TextColumn::make('image')
                    ->label('Image')
                    ->formatStateUsing(fn($state) => "<img src='data:image/jpeg;base64,{$state}' style='width: 100px; height: 100px; object-fit: cover;' />")
                    ->html(),
                TextColumn::make('description'),
                CheckboxColumn::make('status'),
            ])
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
