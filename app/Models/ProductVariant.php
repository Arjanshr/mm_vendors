<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock_quantity',
    ];

    // Relationship: A variant belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship: A variant has many options (specifications like RAM, ROM, Color)
    public function variant_options()
    {
        return $this->hasMany(ProductVariantOption::class);
    }
    
}
