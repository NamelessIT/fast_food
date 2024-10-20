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
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                ->label('Họ và tên khách hàng')
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
                TextColumn::make('id')->label('Mã khách hàng'),
                TextColumn::make('full_name')->label('Họ và tên khách hàng'),
                TextColumn::make('phone')->label('Số liên lạc'),
                TextColumn::make('points')->label('Điểm tích lũy'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
