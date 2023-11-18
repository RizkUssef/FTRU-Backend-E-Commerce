<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];


    public function countryUser(){
        return $this->hasMany(User::class);
    }

    public function countryAddress(){
        return $this->hasMany(Address::class);
    }
}
