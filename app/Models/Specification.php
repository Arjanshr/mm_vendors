<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Specification extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('value');
    }    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function getNameAttribute($value)
    {
        return str_contains($value, 'Undefined')?null:$value;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_specification')
            ->withPivot('is_variant');
    }

    public function productVariantOptions()
    {
        return $this->hasMany(ProductVariantOption::class);
    }
}
