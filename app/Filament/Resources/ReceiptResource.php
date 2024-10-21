<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptResource\Pages;
use App\Filament\Resources\ReceiptResource\RelationManagers;
use App\Models\Receipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Employee;
class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_employee')
                ->label('Mã nhân viên')
                ->required()
                ->options(Employee::pluck('full_name', 'id')->toArray())
                ->placeholder('Chọn nhân viên thực hiện'),

                TextInput::make('total')
                ->label('Tổng tiền (vnd)')
                ->numeric()
                ->rules('required|numeric|min:0')
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
                TextColumn::make('id')->label('Mã phiếu nhập'),
                TextColumn::make('id_employee')->label('Mã nhân viên'),
                TextColumn::make('total')->label('Tổng tiền (vnd)'),
                TextColumn::make('created_at')->label('Ngày tạo phiếu nhập'),
                TextColumn::make('updated_at')->label('Ngày cập nhật phiếu nhập'),
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
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}