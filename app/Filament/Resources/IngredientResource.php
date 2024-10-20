<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IngredientResource\Pages;
use App\Filament\Resources\IngredientResource\RelationManagers;
use App\Models\Ingredient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;

    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ingredient_name')
                ->label('Tên nguyên liệu')
                ->required(),

                TextInput::make('remain_quantity')
                ->label('Lượng nguyên liệu còn lại')
                ->required()
                ->placeholder('Vui lòng nhập lượng nguyên liệu')
                ->numeric()
                ->rules('required|numeric|min:0') // Chỉ cho phép số không âm
                ->reactive(),
                
                TextInput::make('unit')
                ->label('Đơn vị')
                ->required(),
                
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
                TextColumn::make('id')->label('Mã nguyên liệu') ,
                TextColumn::make('ingredient_name')->label('Tên nguyên liệu') ,
                TextColumn::make('remain_quantity')->label('Lượng nguyên liệu còn lại') ,
                TextColumn::make('unit')->label('Đơn vị đo') ,
                TextColumn::make('created_at')->label('Ngày tạo') ,
                TextColumn::make('created_at')->label('Ngày cập nhật') ,
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
            'index' => Pages\ListIngredients::route('/'),
            'create' => Pages\CreateIngredient::route('/create'),
            'edit' => Pages\EditIngredient::route('/{record}/edit'),
        ];
    }
}
