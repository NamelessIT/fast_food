<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $pluralLabel = 'Khách hàng (Customer)';
    protected static ?string $navigationIcon = 'heroicon-s-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                    ->label('Họ và tên')
                    ->required(),

                TextInput::make('phone')
                    ->label('Số liên lạc')
                    ->required()
                    ->placeholder('Vui lòng nhập số điện thoại')
                    ->rules('required|regex:/^0[0-9]{9}$/')
                    ->numeric()
                    ->maxLength(10)
                    ->minLength(10)
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        if (strlen($state) === 10 && !preg_match('/^0[0-9]{9}$/', $state)) {
                            $set('phone', ''); // Chỉ reset nếu nhập đủ 10 ký tự mà không đúng định dạng
                        }
                    }),

                TextInput::make('points')
                    ->label('Điểm tích lũy')
                    ->readOnly()
                    ->numeric()
                    ->default(0),


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

/*                         // Trường tải ảnh mới và chuyển sang Base64
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
                            }), */

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
                TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault:true)
                    ->label('Mã khách hàng'),
                TextColumn::make('full_name')
                    ->sortable()
                    ->searchable()
                    ->label('Họ và tên'),
                TextColumn::make('phone')
                    ->label('Số liên lạc'),
                TextColumn::make('points')
                    ->label('Điểm tích lũy'),
                TextColumn::make('account.avatar')
                    ->label('Avatar')
                    ->formatStateUsing(fn($state) => "<img src='data:image/jpeg;base64,{$state}' style='width: 100px; height: 100px; object-fit: cover;' />")
                    ->html(),
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
                    }),
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
                    ->label('Hiển thị khách hàng đã xóa')
                    ->form([
                        Checkbox::make('trashed')  // Tạo một checkbox để chọn lọc
                            ->label('Khách hàng đã xóa')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
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
            return false;
        if ($user->user->id_role==1)
            return true;
    }
}
