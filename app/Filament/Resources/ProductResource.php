<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use League\CommonMark\Input\MarkdownInput;
use Symfony\Contracts\Service\Attribute\Required;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

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
                TextInput::make('cod_price'),
                TextInput::make('price'),
                TextInput::make('id_promotion')
                    ->default(0),
                MarkdownEditor::make('description'),
                FileUpload::make('image_show')
                    ->disk('public')
                    ->directory('images/product')
                    ->label('Image'),
                Checkbox::make('status')
                    ->default(true),

                    Forms\Components\Repeater::make('recipes')
                    ->relationship('recipes')
                    ->schema([
                        Forms\Components\Select::make('id_ingredient')
                            ->relationship('ingredient', 'ingredient_name')
                            ->label('Ingredient')
                            ->required()
                            ->reactive() // Để lắng nghe thay đổi
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Cập nhật unit khi id_ingredient thay đổi
                                if ($state) {
                                    $ingredient = Ingredient::find($state);
                                    if ($ingredient) {
                                        $set('unit', $ingredient->unit); // Cập nhật giá trị unit
                                    }
                                } else {
                                    $set('unit', null); // Xóa giá trị nếu không có ingredient
                                }
                            }),
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
                ImageColumn::make('image_show')
                    ->toggleable()
                    ->size(180),
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
