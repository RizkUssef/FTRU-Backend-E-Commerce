<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public function subcategoryCategory(){
        return $this->belongsTo(Category::class);   
    }

    public function subcategoryProduct(){
        return $this->hasMany(Product::class);   
    }
}
