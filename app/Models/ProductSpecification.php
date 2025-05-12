<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductSpecification extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'product_specification';
    protected $fillable = [
        'product_id',
        'specification_id',
        'value',
    ];

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
}
