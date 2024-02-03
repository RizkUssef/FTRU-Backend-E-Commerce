<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'color',
        'product_id',
        'created_at',
        'updated_at'
    ];

    public function colorProduct(){
        return $this->belongsTo(Product::class,"product_id","id");
    }

    public function colorSize(){
        return $this->belongsToMany(ProductSize::class, 'product_color_sizes','product_colors_id','product_sizes_id')->withPivot('id','product_colors_id','product_sizes_id','quantity',"image");
    }

    // public function ProColorProCS(){
    //     return $this->hasMany(ProductColorSize::class);
    // }
}
