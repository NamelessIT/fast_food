<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
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
                TextInput::make('id_promotion'),
                MarkdownEditor::make('description'),
                FileUpload::make('image_show')
                    ->disk('public')
                    ->directory('images/product')
                    ->label('Image'),
                Checkbox::make('status')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name'),
                TextColumn::make('category.category_name'),
                TextColumn::make('cod_price'),
                TextColumn::make('price'),
                TextColumn::make('id_promotion'),
                TextColumn::make('description'),
                ImageColumn::make('image_show'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}