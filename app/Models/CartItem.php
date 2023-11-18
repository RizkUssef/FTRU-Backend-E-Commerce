<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'quantity',
        'price',
        'cart_id',
        'product_color_size_id',
        'created_at',
        'updated_at'
    ];

    public function cartitemProuductSC(){
        return $this->hasMany(ProductColorSize::class,"product_color_size_id");
    }

    public function cartitemCart(){
        return $this->belongsTo(Cart::class);
    }
}
