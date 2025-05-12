@extends('adminlte::page')

@section('title', 'Coupon Report')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Coupon Report</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Code</th>
                    <td>{{ $coupon->code }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>{{ ucfirst($coupon->type) }}</td>
                </tr>
                <tr>
                    <th>Discount</th>
                    <td>{{ ($coupon->type == 'fixed' ? 'RS ' : '') . $coupon->discount . ($coupon->type == 'percentage' ? ' %' : '') }}</td>
                </tr>
                <tr>
                    <th>Max Uses</th>
                    <td>{{ $coupon->max_uses ?? 'Unlimited' }}</td>
                </tr>
                <tr>
                    <th>Usage Count</th>
                    <td>{{ $coupon_usage_count }}</td>
                </tr>
                <tr>
                    <th>Total Discount from Orders</th>
                    <td>RS {{ $total_discount }}</td>
                </tr>
                <tr>
                    <th>Expiration Date</th>
                    <td>{{ \Carbon\Carbon::parse($coupon->expires_at)->format('d M, Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        {{ ucfirst($coupon->status ? 'active' : 'inactive') }}
                        @if ($coupon->expires_at && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($coupon->expires_at)))
                            (expired)
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('coupons') }}" class="btn btn-secondary">Back to Coupons</a>
            <a href="{{ route('coupons.orders', $coupon->id) }}" class="btn btn-primary">Show Orders</a>
        </div>
    </div>
</div>
@endsection
