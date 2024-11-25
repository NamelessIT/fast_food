<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use  Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\Facades\Auth;

// use Filament\Pages\Page;

class Dashboard extends \Filament\Pages\Dashboard
{
    
    use HasFiltersForm;
    public function filtersForm(Form $form):Form{
        return $form->schema([
            Section::make('')->schema([
                TextInput::make('name'),
                //nếu name không trống thì sẽ chart line (sản phẩm đó bán trong khoảng thời gian đó như thế nào chia ra theo ngày)
                DatePicker::make('startDate'),
                DatePicker::make('endDate'),
                Select::make('Range')
                ->label('Top')
                ->options([
                    5=>5,
                    10=>10,
                    20=>20,
                ]),
                Toggle::make(name: 'Money'),
                //tìm sản phẩm trong top bán chạy nhất , ế nhất
                Toggle::make('Descrease'),
                // có bật tìm sản phẩm bán ế nhất , chạy nhất
                Toggle::make('active')
                ,
            ])->columns(4),
                // có bật filter không , nếu có thì sẽ chart line (sản phẩm đó bán trong khoảng thời gian đó như thế nào chia ra theo ngày)
            ]);

    }

    public static function canAccess(): bool
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
