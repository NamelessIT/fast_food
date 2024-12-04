<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IngredientSuppliedResource\Pages;
use App\Filament\Resources\IngredientSuppliedResource\RelationManagers;
use App\Models\IngredientSupplied;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Supplier;
use App\Models\Ingredient;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;

class IngredientSuppliedResource extends Resource
{
    protected static ?string $model = IngredientSupplied::class;
    protected static ?string $pluralLabel = 'Giá nhập (Ingredient_Supplied)';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_supplier')
                    ->label('Nhà cung cấp')
                    ->options(Supplier::pluck('supplier_name', 'id')->toArray())
                    ->required(),

                Select::make('id_ingredient')
                    ->label('Nguyên liệu')
                    ->options(Ingredient::pluck('ingredient_name', 'id')->toArray())
                    ->required(),

                TextInput::make('ingredient_price')
                    ->label('Giá nhập nguyên liệu')
                    ->numeric()
                    ->rules('required|numeric|min:1')
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) { // Sửa đổi đây
                        if ($state === '') {
                            $set('Giá nhập nguyên liệu', ''); // Xóa giá trị nếu trường trống
                        }
                    }),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ingredient.ingredient_name')
                    ->label('Tên nguyên liệu')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('supplier.supplier_name') // Truy xuất tên nhà cung cấp từ bảng Supplier
                    ->label('Tên nhà cung cấp')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),


                TextColumn::make('ingredient_price')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Giá nhập hàng'),

                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Ngày tạo'),
                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Ngày cập nhật'),
            ])
            ->filters([
                //
                //Tables\Filters\TrashedFilter::make(),
                Filter::make('trash')
                ->label('Hiển thị danh mục đã xóa')
                ->form([
                    Checkbox::make('trashed')
                        ->label('Danh mục đã xóa')
                        ->default(false), // Mặc định là chưa chọn
                ])
                ->query(function ($query, $data) {
                    if ($data['trashed']) {
                        //$trashedCategories = Category::onlyTrashed()->get();
                        //dd($trashedCategories);
                        // Hiển thị các mục đã xóa (soft deleted)
                        return $query->onlyTrashed();
                    }
                    //dd($query->toSql(), $query->getBindings());  // Xem truy vấn SQL
                    // Hiển thị các mục chưa xóa (whereNull cho trường deleted_at)
                    return $query->whereNull('deleted_at');
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            'index' => Pages\ListIngredientSupplieds::route('/'),
            'create' => Pages\CreateIngredientSupplied::route('/create'),
            'edit' => Pages\EditIngredientSupplied::route('/{record}/edit'),
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
