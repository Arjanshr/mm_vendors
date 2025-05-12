@extends('adminlte::page')

@section('title', 'Orders for Coupon: ' . $coupon->code)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Orders for Coupon: {{ $coupon->code }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_discount = 0; @endphp
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ $order->grand_total }}</td>
                            <td>{{ $order->coupon_discount }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>
                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                        @if ($order->status === 'delivered')
                            @php $total_discount += $order->coupon_discount; @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No orders found for this coupon.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                <h5>Total Discounts from Delivered Orders: RS {{ $total_discount }}</h5>
            </div>
            {{ $orders->links() }}
        </div>
        <div class="card-footer">
            <a href="{{ route('coupons.show', $coupon->id) }}" class="btn btn-secondary">Back to Coupon Report</a>
        </div>
    </div>
</div>
@endsection
