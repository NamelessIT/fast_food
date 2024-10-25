<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
        return $form
            ->schema([
                Hidden::make('user_type')
                    ->default('user_type_mac_dinh'),

                Hidden::make('id_user')
                    ->default(request()->query('id_user')),

                TextInput::make('username')
                    ->unique(ignoreRecord: true) // Bỏ qua usernam hiện tại của bản ghi khi cập nhật
                    ->required(),
                TextInput::make('password')
                    ->required()
                    ->visibleOn('create')
                    ->password()
                    ->revealable(),

                FileUpload::make('avatar')
                    ->disk('public')
                    ->directory('images/avatar'),
                TextInput::make('email')
                    ->unique(ignoreRecord: true) // Bỏ qua email hiện tại của bản ghi khi cập nhật
                    ->required()
                    ->email(),


                Checkbox::make('status')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('user_type'),
                TextColumn::make('username'),
                ImageColumn::make('avatar')
                    ->height(150)
                    ->width(150),
                TextColumn::make('email'),

                CheckboxColumn::make('status'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
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
            //helo
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
