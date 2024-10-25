<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Role;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-s-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                ->label('Họ và tên nhân viên')
                ->required(),

                TextInput::make('phone')
                ->unique(ignoreRecord:true)
                ->label('Số điện thoại')
                ->required()
                ->placeholder('Vui lòng nhập số điện thoại')
                //->rules('required|regex:/^0[0-9]{9}$/')
                ->numeric()
                ->maxLength(11)
                ->minLength(1)
                ->reactive()
                /* ->afterStateUpdated(function ($state, $set) {
                    if (strlen($state) === 10 && !preg_match('/^0[0-9]{9}$/', $state)) {
                        $set('phone', ''); // Chỉ reset nếu nhập đủ 10 ký tự mà không đúng định dạng
                    }
                }) */,

                Select::make('id_role')
                ->label('Phân loại nhân viên')
                ->required()
                ->options(Role::pluck('role_name', 'id'))
                ->placeholder('Chọn loại nhân viên'),

                TextInput::make('salary')
                ->label('Lương (vnd)')
                ->required()
                ->numeric()
                ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label('Họ và tên nhân viên'),
                TextColumn::make('phone')->label('Số liên lạc'),
                TextColumn::make('role.role_name')
                    ->label('Loại nhân viên'),
                TextColumn::make('salary')->label('Lương (vnd)'),
                TextColumn::make('created_at')->label('Ngày tạo'),
                TextColumn::make('updated_at')->label('Ngày cập nhật'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
