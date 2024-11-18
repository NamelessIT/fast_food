<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\View;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $pluralLabel = 'Sản Phẩm (Product)';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('product_name')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Select::make('id_category')
                    ->required()
                    ->options(Category::pluck('category_name', 'id'))
                    ->label('Category'),
                TextInput::make('cod_price')
                    ->default(0),
                TextInput::make('price')
                    ->default(0),
                TextInput::make('id_promotion')
                    ->default(0),
                MarkdownEditor::make('description'),
/*                 FileUpload::make('image_show')
                -
                    ->disk('public')
                    ->directory('images/product')
                    ->label('Image'), */

/*                 TextInput::make('image_show')
                    ->label('Current Image')
                    ->disabled()  // Không cho phép chỉnh sửa
                    ->default(function ($record) {
                        return $record->image_show ?
                            '<img src="' . $record->image_show . '" width="150" height="150" />' :
                            'No image';
                    })
                    ->helperText('This is the image in base64 format'), */

                    // Trường View để render ảnh Base64
                // Sử dụng View để hiển thị ảnh Base64
                View::make('image_show')
                    ->label('Current Image')
                    ->view('filament.show-image', [
                        'imageBase64' => $form->getRecord()->image_show,  // Lấy ảnh Base64 từ bản ghi
                    ]),


/*                 FileUpload::make('image_file')
                    ->label('Upload/Update Image')
                    //->image()
                    ->required()
                    ->directory('temp') // Tạo thư mục tạm
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            // Đọc file và chuyển thành Base64
                            $imageData = file_get_contents($state->getRealPath());
                            $imageBase64 = base64_encode($imageData);

                            // Lưu Base64 vào cột image_show
                            $set('image_show', 'data:image/jpeg;base64,' . $imageBase64);


                            // Xóa file bằng cách sử dụng unlink
                            unlink($state->getRealPath());
                        }
                    }),

                Hidden::make('image_show'), */ // Cột lưu dữ liệu Base64

                FileUpload::make('image_file')
                ->label('Upload/Change Image')
                //->image()  // Giới hạn chỉ tải ảnh
                //->required()
                ->directory('images')  // Chỉ định thư mục lưu trữ tạm thời
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        // Đọc file và chuyển thành Base64
                        $imageData = file_get_contents($state->getRealPath());
                        $imageBase64 = base64_encode($imageData);

                        // Lưu Base64 vào cột image_show trong cơ sở dữ liệu
                        $set('image_show', 'data:image/jpeg;base64,' . $imageBase64);

                        // Xóa file tạm sau khi chuyển đổi sang Base64
                        unlink($state->getRealPath());
                    }
                })
                ,

            Hidden::make('image_show')
                ->default(function ($record) {
                    // Lấy ảnh Base64 từ cơ sở dữ liệu và lưu vào trường ẩn image_show
                    return $record->image_show;
                }),


                Checkbox::make('status')
                    ->default(true),

                    Forms\Components\Repeater::make('recipes')
                    ->relationship('recipes')
                    ->schema([
                        Forms\Components\Select::make('id_ingredient')
                            ->relationship('ingredient', 'ingredient_name')
                            ->label('Ingredient')
                            ->required()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->reactive() // Để lắng nghe thay đổi
                            ->afterStateUpdated(fn ($state, Set $set) => $set('unit',Ingredient::find($state)?->unit ?? null))
                            /* ->afterStateUpdated(function ($state, callable $set) {
                                // Cập nhật unit khi id_ingredient thay đổi
                                if ($state) {
                                    $ingredient = Ingredient::find($state);
                                    if ($ingredient) {
                                        $set('unit', $ingredient->unit); // Cập nhật giá trị unit
                                    }
                                } else {
                                    $set('unit', null); // Xóa giá trị nếu không có ingredient
                                }
                            }) */
                            ->preload()
                            ->searchable(),
                        Forms\Components\TextInput::make('unit')
                            ->label('Unit')
                            ->disabled(), // Chỉ hiển thị, không cho phép chỉnh sửa
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->grid(2)
                    ->defaultItems(0)
                    ->reorderableWithButtons()
                    ->label('Công thức')
                    ->addActionLabel('Thêm vào công thức')
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $livewire) {
                        $data['id_product'] = $livewire->record->id;
                        return $data;
                    })
                    ->afterStateHydrated(function ($state, callable $set) {
                        // Đặt giá trị cho unit từ ingredient
                        foreach ($state as $index => $recipe) {
                            if (isset($recipe['id_ingredient'])) {
                                $ingredient = Ingredient::find($recipe['id_ingredient']);
                                if ($ingredient) {
                                    $set("recipes.$index.unit", $ingredient->unit);
                                }
                            }
                        }
                    }),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category.category_name')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('cod_price')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('price')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('id_promotion')
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('description'),
/*                 ImageColumn::make('image_show')
                    ->toggleable()
                    ->size(180), */

                TextColumn::make('image_show')
                    ->label('Image')
                    ->formatStateUsing(fn($state) => "<img src='{$state}' style='width: 100px; height: 100px;' />")
                    ->html(), // Kích hoạt HTML để hiển thị ảnh từ chuỗi Base64

                CheckboxColumn::make('status')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Ngày tạo')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Ngày cập nhật')
                    ->sortable(),


            ])
            ->filters([
                //
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
