<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_receipt',
        'id_ingredient',
        'quantity',
        'total_price',
        'created_at',
        'updated_at',
    ];
    
    protected $primaryKey = 'id_ingredient'; // Đặt khóa chính phức hợp
    public $incrementing = false; // Không tự động tăng


    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'id_receipt', 'id');
    }


    public function ingredientSupplied()
    {
        return $this->belongsTo(IngredientSupplied::class, 'id_ingredient', 'id_ingredient');
    }

    public function ingredient(){
        return $this->belongsTo(Ingredient::class,'id_ingredient', 'id');
    }
 
    /*protected static function booted()
    {
        static::saved(function ($receiptDetail) {
            // Kiểm tra nếu tổng giá trị chưa được cập nhật hoặc bị thay đổi
            if ($receiptDetail->wasChanged('quantity') || $receiptDetail->wasChanged('id_ingredient')) {
                $receiptDetail->updateTotalPrice1(); // Tính toán lại total_price
            }
    
            // Cập nhật tổng total của Receipt
            if ($receiptDetail->receipt) {
                $receiptDetail->receipt->updateTotal();
            }
        });
    
        static::deleted(function ($receiptDetail) {
            if ($receiptDetail->receipt) {
                $receiptDetail->receipt->updateTotal();
            }
        });
    }*/
    protected static function booted()
{
    static::saved(function ($receiptDetail) {
        // Kiểm tra nếu tổng giá trị chưa được cập nhật hoặc bị thay đổi
        if ($receiptDetail->wasChanged('quantity') || $receiptDetail->wasChanged('id_ingredient')) {
            $receiptDetail->updateTotalPrice1(); // Tính toán lại total_price
        }

        // Cập nhật tổng total của Receipt
        if ($receiptDetail->receipt) {
            $receiptDetail->receipt->updateTotal();
        }

        // Cập nhật lại số lượng còn lại trong Ingredient
        $ingredient = Ingredient::find($receiptDetail->id_ingredient);

        if ($ingredient) {
            // Trừ đi số lượng đã nhập từ remain_quantity
            $ingredient->remain_quantity += $receiptDetail->quantity;
            $ingredient->save(); // Lưu lại thông tin mới
        } else {
            // Xử lý nếu không tìm thấy nguyên liệu
            dd('Ingredient not found for ID: ' . $receiptDetail->id_ingredient);
        }
    });

    static::deleted(function ($receiptDetail) {
        // Khôi phục số lượng nguyên liệu khi ReceiptDetail bị xóa
        $ingredient = Ingredient::find($receiptDetail->id_ingredient);

        if ($ingredient) {
            // Thêm lại số lượng khi xóa ReceiptDetail
            $ingredient->remain_quantity += $receiptDetail->quantity;
            $ingredient->save();
        } else {
            // Xử lý nếu không tìm thấy nguyên liệu
            dd('Ingredient not found for ID: ' . $receiptDetail->id_ingredient);
        }

        // Cập nhật tổng total của Receipt khi một ReceiptDetail bị xóa
        if ($receiptDetail->receipt) {
            $receiptDetail->receipt->updateTotal();
        }
    });
}

    


    public function updateTotalPrice1()
    {
        // Kiểm tra xem giá nguyên liệu có thay đổi không trước khi tính toán lại
        $ingredientSupplied = IngredientSupplied::where('id_ingredient', $this->id_ingredient)->first();

        if ($ingredientSupplied) {
            $ingredientPrice = $ingredientSupplied->ingredient_price ?? 0;
            $newTotalPrice = $ingredientPrice * $this->quantity; // Tính tổng giá

            // Nếu tổng giá khác với giá hiện tại, mới lưu lại
            if ($this->total_price !== $newTotalPrice) {
                $this->total_price = $newTotalPrice;
                $this->saveQuietly(); // Lưu mà không kích hoạt lại event saved
            }
        } else {
            throw new \Exception('IngredientSupplied không tìm thấy');
        }
    }


}
