<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'stock',
        'quantity',
        'image',
        'product_colors_id',
        'product_sizes_id',
        'created_at',
        'updated_at'
    ];
    
    public function productcolorsizeCartItem(){
        return $this->belongsTo(CartItem::class,"product_color_size_id");
    }

    public function productcolorsizeReview(){
        return $this->hasMany(Review::class);
    }
}
