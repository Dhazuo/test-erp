<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;

    protected $table = 'product_history';

    protected $fillable = [
        'product_id',
        'total_sales',
        'total_gains'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
