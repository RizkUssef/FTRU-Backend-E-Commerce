<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_code',
        'sub_total',
        'discount',
        'tax',
        'shipping',
        'total',
        'quantity',
        'email',
        'phone',
        'status',
        'user_id',
        'cart_id',
        'address_id',
        'created_at',
        'updated_at'
    ];

    public function orderUser(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function orderCart(){
        return $this->belongsTo(Cart::class);
    }

    public function orderAddress(){
        return $this->hasOne(Address::class,"id",'address_id');
    }

    public function orderProductCS(){
        return $this->belongsToMany(ProductColorSize::class, 'order_details','order_id','product_color_size_id')->withPivot('id','order_id','product_color_size_id','quantity');
    }

    public function OrderOrderDetails(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

}
