<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'email_verified_at',
        'image',
        'main_address',
        'phone',
        'gender',
        'user_type',
        'provider_name',
        'provider_id',
        'provider_token',
        'remember_token',
        'country_id',
        'created_at',
        'updated_at'
    ];

    //one-many
    public function userAddress()
    {
        return $this->hasMany(Address::class, "user_id");
    }

    //one-many
    public function userOrder()
    {
        return $this->hasMany(Order::class, "user_id");
    }

    // one-many
    public function userReview()
    {
        return $this->hasMany(Review::class, "user_id");
    }

    // one-one
    public function userCart()
    {
        return $this->hasOne(Cart::class, "user_id");
    }

    // many-one
    public function userCountry()
    {
        return $this->belongsTo(Country::class, "country_id");
    }

    public function userWishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', "user_id", 'product_id')->withPivot('id', 'product_id', 'user_id');
    }

    public function lastOrder()
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }
}
