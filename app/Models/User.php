<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // TAMBAHAN: role untuk admin / pengguna
        'description',
        'phone',
        'address',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*  
    |--------------------------------------------------------------------------
    | RELASI MODEL
    |--------------------------------------------------------------------------
    */

    // 1. User (pembeli) punya banyak transaksi (orders)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // 2. User punya keranjang (cart)
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // 3. User bisa menjadi penjual (products)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 4. Relasi ke Profile (opsional)
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Accessor untuk photo URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? \Illuminate\Support\Facades\Storage::url($this->photo) : null;
    }
}
