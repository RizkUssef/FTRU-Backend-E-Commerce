<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'size',
        'product_id',
        'created_at',
        'updated_at'
    ];

    public function sizeProduct(){
        return $this->belongsTo(Product::class);
    }

    public function sizeColor(){
        return $this->belongsToMany(ProductColor::class, 'product_color_sizes','product_sizes_id','product_colors_id')->withPivot('id','product_colors_id','product_sizes_id','quantity',"image");
    }
}
