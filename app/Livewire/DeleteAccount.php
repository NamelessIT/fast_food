<?php

namespace App\Livewire;

use Livewire\Component;

class DeleteAccount extends Component
{
    public function DeleteAccount()
{
    // $user = auth()->user();

    // $hasOrders = Order::where('user_id', $user->id)->exists();

    // if ($hasOrders) {
    //     Order::where('user_id', $user->id)->update(['status' => 1]);
    // } else {
    //     $user->delete();
    // }

    // auth()->logout();

    return $this->render();
}

    public function render()
    {
        return view('livewire.delete-account');
    }
}
