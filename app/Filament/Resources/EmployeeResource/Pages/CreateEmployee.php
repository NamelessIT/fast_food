<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

/*     protected function getRedirectUrl(): string
    {
        //cho id của employee vừa tạo gán cho biến là "id_user" rồi truyền và chuyển hướng sang form tạo account
        $employeeId = $this->record->id;
        return AccountResource::getUrl('create', ['id_user' => $employeeId]);
    } */
}
