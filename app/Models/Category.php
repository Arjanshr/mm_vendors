<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use HasFactory, LogsActivity, HasSlug;
    protected $fillable = [
        'type',
        'name',
        'parent_id',
        'status',
        'image',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')
            ->with('parent');
    }

    public function lastChild()
    {
        return $this->hasOne(Category::class, 'parent_id')->latest('id');
    }


    public function getAllChildren()
    {
        $categories = new Collection();
        foreach ($this->children as $category) {
            $categories->push($category);
            $categories = $categories->merge($category->getAllChildren());
        }
        return $categories;
    }

    public function getAllParent()
    {
        $categories = new Collection();
        if (isset($this->parent) || $this->parent != null) {
            $categories->push($this->parent);
            $categories = $categories->merge($this->parent->getAllParent());
        }
        return $categories;
    }

    public function getParentTree()
    {
        $categories = $this->getAllParent();
        $tree = '';
        foreach ($categories->reverse() as $key => $category) {
            if ($key == $categories->count() - 1)
                $tree = $category->name;
            else
                $tree = $tree . '&#8594' . $category->name;
        }
        return $tree;
    }

    public function getAllChildrenIds()
    {
        return $this->getAllChildren()->pluck('id');
    }

    public function checkIfHasItems()
    {
        // $expense_count = Expense::where('category_id', $this->id)->count();
        // $lead_count = Lead::where('category_id', $this->id)->count();
        // if ($expense_count + $lead_count > 0) return true;
        return false;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class)
            ->withPivot('is_variant')
            ->withPivot('display_order');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }
}
