<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_number',
        'street_number',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function addressUser(){
        return $this->belongsTo(User::class);
    }

    public function addressCountry(){
        return $this->belongsTo(Country::class,"country_id");
    }

    public function addressOrder(){
        return $this->belongsTo(Order::class);
    }
}
