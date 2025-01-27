<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'image',
        'description',
        'main_price',
        'main_discount',
        'product_code',
        'status',
        'delete_status',
        'sub_category_id',
        'created_at',
        'updated_at',
    ];

    public function productSubcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function productColor()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function productSize()
    {
        return $this->hasMany(productSize::class);
    }

    public function productWishlist()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id')->withPivot('id', 'product_id', 'user_id');
    }

    public function productReview()
    {
        return $this->hasMany(Review::class);
    }

}
