<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'rating_value',
        'comment',
        'user_id',
        'product_id',
        'created_at',
        'updated_at'
    ];

    public function reviewUser(){
        return $this->belongsTo(User::class);
    }

    public function reviewProuduct(){
        return $this->belongsTo(Product::class);
    }
}
