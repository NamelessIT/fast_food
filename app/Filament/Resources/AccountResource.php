<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Role;


class AccountResource extends Resource
{
    protected static ?string $model = Account::class;
    //chinh icon duoi day
    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    public static function form(Form $form): Form
    {
        $nhanVienOptions = NhanVien::pluck('ten_nhanvien', 'id')->toArray();

        // Lấy dữ liệu từ bảng khachhang
        $khachHangOptions = KhachHang::pluck('ten_khachhang', 'id')->toArray();
    
        // Kết hợp dữ liệu từ hai bảng
        $options = array_merge($nhanVienOptions, $khachHangOptions);
        return $form
        ->schema([
            Select::make('id_user')
            ->options(Role::pluck('role_name', 'id')->toArray())
                ->placeholder('Chọn chủ tài khoản')
                ->label('Chủ tài khoản')
                ->required(),

                TextInput::make('username')->required(),
                TextInput::make('password')
                    ->required()
                    ->visibleOn('create')
                    ->password()
                    ->revealable(),

                FileUpload::make('avatar')
                    ->disk('public')
                    ->directory('images/avatar'),
                TextInput::make('email')
                    ->required()
                    ->email(),


                Checkbox::make('status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_type'),
                TextColumn::make('username'),
                ImageColumn::make('avatar')
                    ->height(150)
                    ->width(150),
                TextColumn::make('email'),

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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
