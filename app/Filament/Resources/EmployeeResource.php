<?php

namespace App\Filament\Resources;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Account;
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
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\Fieldset as ComponentsFieldset;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $pluralLabel = 'Nhân Viên (Employee)';
    protected static ?string $navigationIcon = 'heroicon-s-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                    ->label('Họ và tên nhân viên')
                    ->validationMessages([
                        'required' => 'Hãy nhập họ và tên',
                    ])
                    ->rules(['required'])
                    ->markAsRequired(),

                TextInput::make('phone')
                    ->unique(ignoreRecord:true)
                    ->label('Số điện thoại')
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Hãy nhập số điện thoại',
                        'unique' => 'Số điện thoại đã tồn tại',
                    ])
                    ->placeholder('Vui lòng nhập số điện thoại')
                    //->rules('required|regex:/^0[0-9]{9}$/')
                    ->numeric()
                    //->maxLength(11)
                    //->minLength(1)
                    //->reactive()
                    /* ->afterStateUpdated(function ($state, $set) {
                        if (strlen($state) === 10 && !preg_match('/^0[0-9]{9}$/', $state)) {
                            $set('phone', ''); // Chỉ reset nếu nhập đủ 10 ký tự mà không đúng định dạng
                        }
                    }) */,

                Select::make('id_role')
                    ->label('Phân loại nhân viên')
                    ->options(Role::pluck('role_name', 'id'))
                    ->placeholder('Chọn loại nhân viên')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Hãy chọn loại nhân viên',
                    ])
                    ->markAsRequired(),

                TextInput::make('salary')
                    ->label('Lương (vnd)')
                    ->required()
                    ->numeric()
                    ->default(0),

                //Các trường của Account
                Fieldset::make('Thông tin account:')
                    ->relationship('account')
                    ->schema([
                        TextInput::make('username')
                            ->unique(ignoreRecord: true) // Bỏ qua usernam hiện tại của bản ghi khi cập nhật
                            ->validationMessages([
                                'required' => 'Hãy nhập username',
                                'unique' => 'username đã tồn tại',
                            ])
                            ->rules(['required'])
                            ->markAsRequired(),

                        TextInput::make('password')
                            ->validationMessages([
                                'required' => 'Hãy nhập mật khẩu',
                            ])
                            ->rules(['required'])
                            ->markAsRequired()
                            ->visibleOn('create')
                            ->password()
                            ->revealable(),

                        FileUpload::make('avatar')
                            ->disk('public')
                            ->directory('images/avatar'),
                        TextInput::make('email')
                            ->unique(ignoreRecord: true) // Bỏ qua email hiện tại của bản ghi khi cập nhật
                            ->markAsRequired()
                            ->rules(['required'])
                            ->email()
                            ->validationMessages([
                                'required' => 'Hãy nhập email',
                                'unique' => 'email đã tồn tại',
                            ]),

                        Checkbox::make('status')
                            ->default(true),
                    ]),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Họ và tên nhân viên')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('account.avatar')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Avatar')
                    ->circular()
                    ->size(100)
                    ->sortable(),
                TextColumn::make('account.username')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Username')
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Số điện thoại'),
                TextColumn::make('role.role_name')
                    ->label('Loại nhân viên')
                    ->sortable(),
                TextColumn::make('salary')
                    ->sortable()
                    ->label('Lương (vnd)'),
                TextColumn::make('account.email')
                    ->label("Email"),
                CheckboxColumn::make('account.status')
                    ->label("Status")
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->disabled(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
