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
        'status',
        'user_id',
        'cart_id',
        'created_at',
        'updated_at'
    ];

    public function orderUser(){
        return $this->belongsTo(User::class);
    }

    public function orderCart(){
        return $this->belongsTo(Cart::class);
    }
}
