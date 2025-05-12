<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Coupon;

class CouponForm extends Component
{
    public $coupon;
    public $code;
    public $type;
    public $discount;
    public $max_uses;
    public $expires_at;
    public $status;
    public $specific_type = 'normal'; // updated to handle multiple specific types
    public $is_user_specific = false;

    public $users = [];
    public $categories = [];
    public $brands = [];
    public $products = [];
    public $user_ids = [];
    public $category_ids = [];
    public $brand_ids = [];
    public $product_ids = [];

    protected $rules = [
        'code' => 'required|string|unique:coupons,code',
        'type' => 'required|in:fixed,percentage',
        'discount' => 'required|numeric|min:0',
        'max_uses' => 'nullable|integer|min:1',
        'expires_at' => 'nullable|date',
        'status' => 'required|integer|in:0,1',
        'user_ids' => 'nullable|array',
        'category_ids' => 'nullable|array',
        'brand_ids' => 'nullable|array',
        'product_ids' => 'nullable|array',
    ];

    public function mount($coupon = null)
    {
        $this->users = User::all();
        $this->categories = Category::all();
        $this->brands = Brand::all();
        $this->products = Product::all();
        // dd($coupon->categories()->get());
        if ($coupon && $coupon->exists) {
            $this->coupon = $coupon;
            $this->code = $coupon->code;
            $this->type = $coupon->type;
            $this->discount = $coupon->discount;
            $this->max_uses = $coupon->max_uses;
            $this->expires_at = optional($coupon->expires_at)->format('Y-m-d\TH:i');
            $this->status = $coupon->status;
            $this->specific_type = $coupon->specific_type; // Set the type
            $this->is_user_specific = $coupon->is_user_specific == 1 ? true : false;

            $this->user_ids = $coupon->users->pluck('id')->toArray();
            $this->category_ids = $coupon->categories->pluck('id')->toArray();
            $this->brand_ids = $coupon->brands->pluck('id')->toArray();
            $this->product_ids = $coupon->products->pluck('id')->toArray();
        }

        $this->dispatch('select2Hydrate');
    }

    public function updatedIsUserSpecific($value)
    {
        if (!$value) {
            $this->user_ids = [];
        }
        $this->dispatch('select2Hydrate');
    }

    public function updatedSpecificType($value)
    {
        if ($value === 'category') {
            $this->category_ids = [];
        } elseif ($value === 'brand') {
            $this->brand_ids = [];
        } elseif ($value === 'product') {
            $this->product_ids = [];
        }
        $this->dispatch('select2Hydrate');
    }

    public function updatedUserIds($value)
    {
        $this->user_ids = $value;
    }

    public function updatedCategoryIds($value)
    {
        $this->category_ids = $value;
    }

    public function updatedBrandIds($value)
    {
        $this->brand_ids = $value;
    }

    public function updatedProductIds($value)
    {
        $this->product_ids = $value;
    }

    public function render()
    {
        return view('admin.livewire.coupon-form');
    }
}
