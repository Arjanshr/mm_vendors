<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = User::role('customer')->get();
        return view('admin.orders.form', compact('customers'));
    }

    public function insert(OrderRequest $request)
    {
        // return $request;
        $shipping_address = "Name: $request->reciever_name";
        $shipping_address .= "<br/>Phone: $request->phone_number";
        $shipping_address .= "<br/>Email: $request->email";
        $area = Area::find($request->area_id);
        $shipping_address .= "<br/><br/> $area->name" . "(" . (ucfirst($request->address_type)) . ")";
        $shipping_address .= "<br/> $request->location";
        $city = City::find($request->city_id);
        $province = Province::find($request->province_id);
        $shipping_address .= "<br/> $city->name";
        $shipping_address .= "<br/> $province->name";
        if (!$request->customer_id) {
            $customer = User::where('email', $request->email)
                ->orWhere('phone', $request->phone_number)
                ->first();
            if (!$customer) {
                $customer = User::create(
                    [
                        'name' => $request->reciever_name,
                        'email' => $request->email,
                        'phone' => $request->phone_number,
                        'password' => bcrypt('password'),
                    ]
                );
                $customer->assignRole('customer');
            }
        } else {
            $customer = User::find($request->customer_id);
        }

        if (!$request->address_id) {
            $address = Address::where('user_id', $customer->id ?? $request->customer_id)
                ->where('type', $request->address_type)
                ->where('city_id', $request->city_id)
                ->where('province_id', $request->province_id)
                ->where('area_id', $request->area_id)
                ->where('location', $request->location)
                ->where('phone_number', $request->phone_number)
                ->first();
            if (!$address) {
                $address = Address::create(
                    [
                        'user_id' =>  $customer->id ?? $request->customer_id,
                        'type' => $request->address_type,
                        'city_id' => $request->city_id,
                        'province_id' => $request->province_id,
                        'area_id' => $request->area_id,
                        'location' => $request->location,
                        'phone_number' => $request->phone_number,
                    ]
                );
            }
        } else {
            $address = Address::find($request->address_id);
        }

        $order = new Order();
        $order->user_id =  $customer->id;
        $order->address_id =  $address->id;
        $order->total_price = $request->total_amount;
        $order->discount = $request->total_discount;
        $order->coupon_code = $request->coupon_code;
        $order->coupon_discount = $request->coupon_discount;
        $order->shipping_price = $request->shipping_price;
        $order->grand_total = $request->grand_total;
        $order->payment_type = $request->payment_type;
        $order->payment_status = $request->payment_status;
        $order->shipping_address = $shipping_address;
        $order->area_id = $area->id;
        $order->save();
        foreach ($request->items as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item['id'];
            $order_item->quantity = $item['quantity'];
            $order_item->price = $item['rate'];
            $order_item->discount = $item['discount'];
            $order_item->save();
        }
        toastr()->success('Order Created Successfully!');
        return redirect()->route('orders');
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }
    public function edit(Order $order)
    {
        $customers = User::role('customer')->get();
        return view('admin.orders.form', compact('customers', 'order'));
    }

    public function update(Order $order, OrderRequest $request)
    {
        // return $request;
        $shipping_address = "Name: $request->reciever_name";
        $shipping_address .= "<br/>Phone: $request->phone_number";
        $shipping_address .= "<br/>Email: $request->email";
        $area = Area::find($request->area_id);
        $shipping_address .= "<br/><br/> $area->name" . "(" . (ucfirst($request->address_type)) . ")";
        $shipping_address .= "<br/> $request->location";
        $city = City::find($request->city_id);
        $province = Province::find($request->province_id);
        $shipping_address .= "<br/> $city->name";
        $shipping_address .= "<br/> $province->name";
        if (!$request->customer_id) {
            $customer = User::where('email', $request->email)
                ->orWhere('phone', $request->phone_number)
                ->first();
            if (!$customer) {
                $customer = User::create(
                    [
                        'name' => $request->reciever_name,
                        'email' => $request->email,
                        'phone' => $request->phone_number,
                        'password' => bcrypt('password'),
                    ]
                );
                $customer->assignRole('customer');
            }
        } else {
            $customer = User::find($request->customer_id);
        }

        if (!$request->address_id) {
            $address = Address::where('user_id', $customer->id ?? $request->customer_id)
                ->where('type', $request->address_type)
                ->where('city_id', $request->city_id)
                ->where('province_id', $request->province_id)
                ->where('area_id', $request->area_id)
                ->where('location', $request->location)
                ->where('phone_number', $request->phone_number)
                ->first();
            if (!$address) {
                $address = Address::create(
                    [
                        'user_id' =>  $customer->id ?? $request->customer_id,
                        'type' => $request->address_type,
                        'city_id' => $request->city_id,
                        'province_id' => $request->province_id,
                        'area_id' => $request->area_id,
                        'location' => $request->location,
                        'phone_number' => $request->phone_number,
                    ]
                );
            }
        } else {
            $address = Address::find($request->address_id);
        }

        $order->user_id =  $customer->id;
        $order->address_id =  $address->id;
        $order->total_price = $request->total_amount;
        $order->discount = $request->total_discount;
        $order->coupon_code = $request->coupon_code;
        $order->coupon_discount = $request->coupon_discount;
        $order->shipping_price = $request->shipping_price;
        $order->grand_total = $request->grand_total;
        $order->payment_type = $request->payment_type;
        $order->payment_status = $request->payment_status;
        $order->shipping_address = $shipping_address;
        $order->area_id = $area->id;
        $order->save();
        $order->order_items()->delete();
        foreach ($request->items as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item['id'];
            $order_item->quantity = $item['quantity'];
            $order_item->price = $item['rate'];
            $order_item->discount = $item['discount'];
            $order_item->save();
        }
        toastr()->success('Order Created Successfully!');
        return redirect()->route('orders');
    }


    
    public function delete(Order $order)
    {
        $order->delete();
        toastr()->success('Order Created Successfully!');
        return redirect()->route('orders');
    }
}
