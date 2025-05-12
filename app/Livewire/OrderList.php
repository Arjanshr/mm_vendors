<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Component;


class OrderList extends Component
{
    public $order_id;
    public $orders;
    public $order_statuses;
    public $order_status = [];
    public $order;
    public $status;
    public $count;

    public function mount()
    {
        $this->status = 'pending';
        $this->orders = Order::where('status', 'pending')->orderByDesc('id')->get();
        $this->order_statuses = OrderStatus::cases();
        foreach ($this->orders as $order) {
            $this->order_status[$order->id] = $order->status;
        }
        $this->count['all'] = Order::count();

        foreach ($this->order_statuses as $status) {
            $this->count[$status->value] = Order::where('status', $status->value)->count();
        }
    }

    public function change($id)
    {
        $o = Order::find($id);
        if (auth()->user()->can('edit-orders')) {
            $o->status = $this->order_status[$id];
            $o->save();
        }
        $this->orders = Order::where('status', $this->status)->orderByDesc('id')->get();
        if ($this->status == 'all') {
            $this->orders = Order::orderByDesc('id')->get();
        }
        $this->count['all'] = Order::count();
        foreach ($this->order_statuses as $status) {
            $this->count[$status->value] = Order::where('status', $status->value)->count();
        }
    }

    public function filterOrders($status)
    {
        $this->status = $status;
        $this->orders = Order::where('status', $status)->orderByDesc('id')->get();
        foreach ($this->orders as $order) {
            $this->order_status[$order->id] = $order->status;
        }
    }
    public function allOrders()
    {
        $this->status = 'all';
        $this->orders = Order::orderByDesc('id')->get();
        foreach ($this->orders as $order) {
            $this->order_status[$order->id] = $order->status;
        }
    }

    public function render()
    {
        return view('admin.livewire.order-list');
    }
}
