<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use Livewire\Component;

class OrderForm extends Component
{
    public $order;
    public $products;
    public $product_inventory = [];
    public $total_quantity = 0;
    public $total_amount = 0;
    public $total_discount = 0;
    public $shipping_price = 0;
    public $grand_total = 0;
    public $items = [];
    public $customers;
    public $order_items;
    public $customer;
    public $select_product;
    public $address;
    public $reciever_name;
    public $address_type;

    public $provinces;
    public $province;
    public $cities;
    public $city;
    public $areas;
    public $area;
    public $location;
    public $phone_number;
    public $email;
    public $addresses;
    public $coupon_code;
    public $coupon_discount = 0;
    public $applied_coupon;

    public function mount()
    {
        $this->provinces = Province::get();
        $this->cities = City::get();
        $this->areas = Area::get();
        if ($this->order != null) {
            $this->coupon_discount = $this->order->coupon_discount;
            $this->coupon_code = $this->order->coupon_code;
            $this->items = $this->order->order_items;
            if ($this->order->customer) {
                $this->customer = $this->order->customer?->id;
                if ($this->order->customer) {
                    $this->reciever_name = $this->order->customer->name;
                    $this->addresses = $this->order->customer->addresses;
                    if ($this->order->address) {
                        $default_address = $this->order->address;
                    } else {
                        $default_address = $this->order->customer->addresses()->where('is_default', 1)->first();
                    }
                    if ($default_address) {
                        $this->address = $default_address->id;
                        $this->address_type = $default_address->type;
                        $this->province = $default_address->province_id;
                        $this->city = $default_address->city_id;
                        $this->area = $default_address->area_id;
                        $this->shipping_price = $this->order->shipping_price??Area::find($default_address->area_id)->shipping_price;
                        $this->location = $default_address->location;
                        $this->phone_number = $default_address->phone_number;
                        $this->email = $this->order->customer->email;
                    }
                }
            }
        }
        $this->customers = User::role('customer')->get();
        $this->products = Product::where('status', 'publish')->get();
        if (count($this->items) > 0) {
            foreach ($this->items as $item) {
                $this->order_items[] =
                    [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'rate' => $item->price,
                        'discount' => $item->discount,
                        'amount' => $item->quantity * $item->price,
                        'total' => $item->quantity * $item->price - $item->discount
                    ];
            }
        } else {
            $this->order_items = [];
        }
        $this->total_quantity = array_sum(array_column($this->order_items, 'quantity'));
        $this->total_discount = array_sum(array_column($this->order_items, 'discount'));
        $this->total_amount = array_sum(array_column($this->order_items, 'amount'));
        $this->grand_total = array_sum(array_column($this->order_items, 'total')) + $this->shipping_price ?? 0;
        $this->dispatch('select2Hydrate');
    }

    public function removeProduct($index)
    {
        unset($this->order_items[$index]);
        $this->dispatch('select2Hydrate');
    }

    public function updatedProvince($value)
    {
        $this->cities = City::where('province_id', $value)->get();
    }
    public function updatedCity($value)
    {
        $this->areas = Area::where('city_id', $value)->get();
    }
    public function updatedArea($value)
    {
        $this->shipping_price = Area::find($value)->shipping_price;
    }

    public function updatedCustomer($value)
    {
        $customer = User::with('addresses')->find($value);
        $this->reciever_name =
            $this->address_type =
            $this->province =
            $this->city =
            $this->area =
            $this->location =
            $this->location =
            $this->phone_number =
            $this->email =
            $this->addresses = null;
        if ($customer) {
            $this->reciever_name = $customer->name;
            $this->addresses = $customer->addresses;
            $this->email = $customer->email;
            $this->phone_number = $customer->phone_number;

            $default_address = $customer->addresses()->where('is_default', 1)->first();
            if ($default_address) {
                $this->address = $default_address->id;
                $this->address_type = $default_address->type;
                $this->province = $default_address->province_id;
                $this->city = $default_address->city_id;
                $this->area = $default_address->area_id;
                $this->location = $default_address->location;
                $this->shipping_price = Area::find($default_address->area_id)->shipping_price;
                $this->phone_number = $default_address->phone_number;
            }
        }
    }
    public function updatedAddress($value)
    {
        $selected_address = Address::find($value);
        $this->address = $selected_address->id;
        $this->address_type = $selected_address->type;
        $this->province = $selected_address->province_id;
        $this->city = $selected_address->city_id;
        $this->area = $selected_address->area_id;
        $this->location = $selected_address->location;
        $this->location = $selected_address->location;
        $this->phone_number = $selected_address->phone_number;
        $this->shipping_price = Area::find($selected_address->area_id)->shipping_price;
        $this->email = User::find($this->customer)->email;
    }

    public function change($index)
    {
        $this->order_items[$index]['amount'] =  (is_numeric($this->order_items[$index]['rate']) ?
            $this->order_items[$index]['rate'] : 0) * (is_numeric($this->order_items[$index]['quantity']) ?
            $this->order_items[$index]['quantity'] : 0);
        $this->order_items[$index]['total'] =  (is_numeric($this->order_items[$index]['rate']) ?
            $this->order_items[$index]['rate'] : 0) * (is_numeric($this->order_items[$index]['quantity']) ?
            $this->order_items[$index]['quantity'] : 0) - (is_numeric($this->order_items[$index]['discount']) ?
            $this->order_items[$index]['discount'] : 0);
        $this->total_quantity = array_sum(array_column($this->order_items, 'quantity'));
        $this->total_discount = array_sum(array_column($this->order_items, 'discount'));
        $this->total_amount = array_sum(array_column($this->order_items, 'amount'));
        $this->grand_total = array_sum(array_column($this->order_items, 'total')) + $this->shipping_price;
        $this->dispatch('select2Hydrate');
    }


    public function updatedSelectProduct($value)
    {
        $product_inventories = array_column($this->order_items, 'id');
        if (!in_array($value, $product_inventories)) {
            $this->products = Product::whereNotIn('id', $product_inventories)
                ->get();

            $product_inventory = Product::find($value);
            $this->order_items[] = [
                'id' => $product_inventory->id,
                'name' => $product_inventory->name,
                'rate' => $product_inventory->price,
                'quantity' => 1,
                'discount' => 0,
                'amount' => $product_inventory->price,
                'total' => $product_inventory->price,
            ];
            $this->total_quantity = array_sum(array_column($this->order_items, 'quantity'));
            $this->total_discount = array_sum(array_column($this->order_items, 'discount'));
            $this->total_amount = array_sum(array_column($this->order_items, 'amount'));
            $this->grand_total = array_sum(array_column($this->order_items, 'total')) + $this->shipping_price;
            $this->dispatch('select2Hydrate');
        }
    }
    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon_code)->where('status', 1)->first();
        if ($coupon) {
            $this->applied_coupon = $coupon;

            $this->coupon_discount = $coupon->type === 'percentage'
                ? ($this->total_amount * $coupon->discount / 100)
                : $coupon->discount;
        } else {
            $this->coupon_discount = 0;
            $this->applied_coupon = null;
            session()->flash('error', 'Invalid or expired coupon code.');
        }
        // $this->total_discount += $this->coupon_discount;
        $this->calculateTotals();
        toastr()->success('Coupon Applied Successfully!');

    }

    private function calculateTotals()
    {
        $this->total_quantity = array_sum(array_column($this->order_items, 'quantity'));
        $this->total_discount = array_sum(array_column($this->order_items, 'discount')) + $this->coupon_discount;
        $this->total_amount = array_sum(array_column($this->order_items, 'amount'));
        $this->grand_total = max(0, ($this->total_amount - $this->total_discount) + $this->shipping_price);
    }

    public function render()
    {
        return view('admin.livewire.order-form');
    }
}
