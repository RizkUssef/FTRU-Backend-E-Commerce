<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function cartUser(){
        return $this->belongsTo(User::class);
    }

    public function cartOrder(){
        return $this->hasMany(Order::class);
    }

    public function cartCItem(){
        return $this->hasMany(CartItem::class);
    }
}
