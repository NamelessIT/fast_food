<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $label = 'Nhà cung cấp'; //tên biến trong chỗ new
    protected static ?string $pluralLabel = 'Nhà cung cấp (Supplier)'; //label cho resource
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('supplier_name')
                ->label('Tên nhà cung cấp')
                ->required(),

                TextInput::make('phone_contact')
                    ->unique(ignoreRecord:true)
                    ->label('Số liên lạc')
                    ->required()
                    ->placeholder('Vui lòng nhập số điện thoại')
                    ->numeric()
                    ->maxLength(11)
                    ->minLength(1)
                    ->reactive(),


                TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

                TextInput::make('address')
                ->label('Địa chỉ')
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Mã'),
                TextColumn::make('supplier_name')
                    ->label('Tên nhà cung cấp'),
                TextColumn::make('phone_contact')
                    ->label('Liên lạc'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('address')
                    ->label('Địa chỉ'),
                TextColumn::make('created_at')
                    ->label('Ngày tạo'),
                TextColumn::make('updated_at')
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
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
