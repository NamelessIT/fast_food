<?php

namespace App\Livewire\Product\DetailProduct;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Product;
use DB;
use Livewire\Component;

class FeedBackProduct extends Component
{
    public $slug = '';
    public $listFeedBack = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $list = DB::select(
            'SELECT feed_backs.id, feed_backs.content, feed_backs.evaluation, Customers.full_name, Accounts.avatar, feed_backs.created_at
            FROM feed_backs
            JOIN Customers ON feed_backs.id_customer = Customers.id
            JOIN Accounts ON feed_backs.id_customer = Accounts.user_id
            WHERE id_product = ?
            GROUP BY feed_backs.id, feed_backs.content, feed_backs.evaluation, Customers.full_name, Accounts.avatar, feed_backs.created_at
            ORDER BY feed_backs.created_at DESC
            ',
            [
                Product::where('slug', $slug)->first()->id
            ]
            );
        // dd ($list);
        $this->listFeedBack = $list;
    }

    public function render()
    {
        return view('livewire.product.detail-product.feed-back-product');
    }
}