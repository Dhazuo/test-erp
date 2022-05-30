<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'price',
        'original_stock',
        'actual_stock'
    ];

    public function product_sale()
    {
        return $this->hasOne(ProductSale::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'product_sale', 'product_id', 'sale_id')->withPivot('product_id', 'sale_id','total_stock');
    }
}
