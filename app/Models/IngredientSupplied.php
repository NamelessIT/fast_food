<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientSupplied extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_ingredient',
        'id_supplier',
        'ingredient_price',
        'created_at',
        'updated_at',
     ];
    protected $table = 'ingredient_supplieds';
    protected $primaryKey = 'ingredient_price'; // Đặt khóa chính phức hợp
    public $incrementing = false;
    
    // Mối quan hệ với Ingredient
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_ingredient');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
    
}
