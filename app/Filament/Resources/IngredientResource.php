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
use App\Models\Supplier;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;
    protected static ?string $pluralLabel = 'Kho Hàng (Ingredient)';
    protected static ?string $navigationIcon = 'heroicon-s-queue-list';
    protected $table = 'ingredient_suppliers';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ingredient_name')
                    ->unique(ignoreRecord:true)
                    ->label('Tên nguyên liệu')
                    ->required(),

                TextInput::make('unit')
                    ->label('Đơn vị')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Mã nguyên liệu'),
                TextColumn::make('ingredient_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Tên nguyên liệu'),
                TextColumn::make('remain_quantity')
                    ->sortable()
                    ->toggleable()
                    ->label('Lượng nguyên liệu còn lại'),
                TextColumn::make('unit')
                    ->sortable()
                    ->toggleable()
                    ->label('Đơn vị đo'),
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
            'index' => Pages\ListIngredients::route('/'),
            'create' => Pages\CreateIngredient::route('/create'),
            'edit' => Pages\EditIngredient::route('/{record}/edit'),
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
