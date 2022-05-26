<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'seller_id',
        'customer',
        'product_name',
        'total_stock',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->where('role', 'seller');
    }
}
