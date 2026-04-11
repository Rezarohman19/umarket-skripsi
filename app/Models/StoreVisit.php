<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreVisit extends Model
{
    protected $fillable = [
        'store_id',
        'ip_address',
        'visit_date',
    ];

    public function store()
    {
        return $this->belongsTo(User::class, 'store_id');
    }
}
