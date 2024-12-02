<?php
namespace App\Http\Responses;

use App\Filament\Resources\BillResource;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class AdminLoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        //$user = Auth::user();
        $user = auth()->user();
        if ($user->user->id_role==2)
            // Here, you can define which resource and which page you want to redirect to
            return redirect()->to(BillResource::getUrl('index'));
        return redirect('/admin');
    }
}
