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
        return $this->belongsTo(CartItem::class);
    }

    public function productcolorsizeReview(){
        return $this->hasMany(Review::class);
    }

    public function productCSOrder(){
        return $this->belongsToMany(Order::class, 'order_details','product_color_size_id','order_id')->withPivot('id','product_color_size_id','order_id');
    }

    public function ProCSProColor(){
        return $this->belongsTo(ProductColor::class,'product_colors_id','id');
    }

    public function ProCSProSize(){
        return $this->belongsTo(ProductSize::class,'product_sizes_id','id');
    }

}
