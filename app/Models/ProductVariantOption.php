<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'specification_id',
        'value',
    ];

    // Relationship: A product variant option belongs to a variant
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Relationship: A product variant option belongs to a specification
    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
