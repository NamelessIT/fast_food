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
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\View;
use Filament\Infolists\Components\Fieldset as ComponentsFieldset;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Support\Facades\Auth;

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
                    ->markAsRequired()
                    ->label('Phân loại nhân viên')
                    ->options(Role::pluck('role_name', 'id'))
                    ->placeholder('Chọn loại nhân viên')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Hãy chọn loại nhân viên',
                    ]),

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

/*                         FileUpload::make('avatar')
                            ->disk('public')
                            ->directory('images/avatar'), */

                        View::make('account.avatar')
                            ->label('Current Image')
                            ->view('filament.show-image', [
                                'imageBase64' => $form->getRecord() && $form->getRecord()->account ? $form->getRecord()->account->avatar : null,
                            ]),

                        // Trường tải ảnh mới và chuyển sang Base64
                        FileUpload::make('avatar_img')
                            ->label('Upload/Change Image')
                            ->directory('images')  // Thư mục lưu trữ tạm
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    // Đọc file và chuyển thành Base64
                                    $imageData = file_get_contents($state->getRealPath());
                                    $imageBase64 = base64_encode($imageData);

                                    // Lưu Base64 vào cột image trong cơ sở dữ liệu
                                    $set('avatar','' . $imageBase64);

                                    // Xóa file tạm sau khi chuyển đổi sang Base64
                                    unlink($state->getRealPath());
                                }
                            }),

                        // Trường ẩn 'image' lưu giá trị Base64 ảnh
                        Hidden::make('avatar')
                            ->default(function ($record) {
                                // Kiểm tra bản ghi có tồn tại và có ảnh không
                                return $record && isset($record->image) ? $record->image : null;
                            }),

                        TextInput::make('email')
                            ->unique(ignoreRecord: true) // Bỏ qua email hiện tại của bản ghi khi cập nhật
                            ->markAsRequired()
                            ->rules(['required'])
                            ->email()
                            ->validationMessages([
                                'required' => 'Hãy nhập email',
                                'unique' => 'email đã tồn tại',
                            ]),

                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                1 => 'Hoạt động',
                                2 => 'Khóa',
                            ])
                            ->default(1) // Mặc định là "Hoạt động"
                            ->afterStateUpdated(function ($state, $record) {
                                // Cập nhật lại trạng thái vào cơ sở dữ liệu
                                $record->status = $state;
                                $record->save();
                            })
                            ->helperText('Chọn trạng thái tài khoản'),

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
/*                 ImageColumn::make('account.avatar')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Avatar')
                    ->circular()
                    ->size(100)
                    ->sortable(), */

                TextColumn::make('account.avatar')
                    ->label('Avatar')
                    ->formatStateUsing(fn($state) => "<img src='data:image/jpeg;base64,{$state}' style='width: 100px; height: 100px; object-fit: cover;' />")
                    ->html(),
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
                    ->money('VND')
                    ->label('Lương (vnd)'),
                TextColumn::make('account.email')
                    ->label("Email"),

                SelectColumn::make('account.status') // Cột chọn trạng thái
                    ->label('Trạng thái')
                    ->sortable()
                    ->options([
                        1 => 'Hoạt động',
                        2 => 'Khóa',
                    ])
                    ->afterStateUpdated(function ($state, $record) {
                        $record->account->status = $state; // Cập nhật trạng thái trong cơ sở dữ liệu
                        $record->account->save(); // Lưu thay đổi vào cơ sở dữ liệu
                    })
                    ,

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
                //Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('trashed')
                    ->label('Hiển thị nhân viên đã xóa')
                    ->form([
                        Checkbox::make('trashed')  // Tạo một checkbox để chọn lọc
                            ->label('Nhân viên đã xóa')
                            ->default(false),  // Mặc định là chưa chọn
                    ])
                    ->query(function ($query, $data) {
                        if ($data['trashed']) {
                            return $query->onlyTrashed();  // Hiển thị món đã xóa
                        }

                        return $query->whereNull('deleted_at');  // Hiển thị món chưa xóa
                    }),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                //Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    //Tables\Actions\ForceDeleteBulkAction::make(),
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

    public static function canViewAny(): bool
    {
        // Lấy người dùng đang đăng nhập
        $user = Auth::user();
        //$user = auth()->user();

        if ($user->user->id_role==2) //nhân viên bình thường
            return false;
        if ($user->user->id_role==1)
            return true;
    }
}
