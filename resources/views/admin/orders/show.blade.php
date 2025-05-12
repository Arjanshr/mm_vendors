@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
    <h1>Orders</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header clearfix">
                            <div class="row">
                                <div class="col-9">
                                    <button onclick="printInvoice()" class="btn btn-outline-primary btn-icon">
                                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2 me-2"></i>Print
                                    </button>

                                </div>
                                <div class="col-3 pull-right">
                                    Invoice
                                </div>
                            </div>

                        </div>
                        <div id="invoice">
                            <div class="card-body">
                                <div class="row">
                                    <div id="client" class="col-4">
                                        <div class="to">INVOICE TO: <b>{{ $order->customer->name }}</b> </div>
                                        <div class="address">{{ $order->customer->phone }}</div>
                                        <div class="email">{{ $order->customer->email }}</div>
                                    </div>
                                    <div id="client" class="col-4">
                                        <div class="to">Shipping Address:</div>
                                        <div class="address"><b>{!! $order->shipping_address !!}</b> </div>
                                    </div>
                                    <div id="invoice" class="col-4">
                                        INVOICE NO : <b>#{{ $order->id }}</b>
                                        <div class="date">Issue Date: {{ $order->created_at->format('m/d/Y') }}</div>
                                        <div class="date">Payment Type/Status: {{ ucfirst($order->payment_type) }}
                                            ({{ ucfirst($order->payment_status) }})</div>
                                        {{-- <div class="date">Vat no: {{ $order->customer->vat_no }}</div> --}}
                                    </div>
                                </div>
                                <table class="table table-bordered table-hover table-responsive-lg align-middle">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="no text-center">#</th>
                                            <th class="photo text-center">Photo</th>
                                            <th class="title">Name</th>
                                            <th class="qty text-center">Quantity</th>
                                            <th class="rate text-right">Rate</th>
                                            <th class="amnt text-right">Amount</th>
                                            <th class="disc text-right">Discount</th>
                                            <th class="total text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->order_items as $item)
                                            <tr>
                                                <td class="no text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="photo text-center align-middle">
                                                    @php
                                                        $img = $item->product->getFirstMediaUrl() ?: null;
                                                    @endphp
                                                    <img src="{{ $img ?: 'https://via.placeholder.com/50x50?text=No+Image' }}"
                                                         alt="Product Image"
                                                         style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                                </td>
                                                <td class="desc align-middle">
                                                    <a href="{{ route('product.show', $item->product_id) }}">
                                                        {{ $item->product->name }}
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $item->variant ? $item->variant->sku : 'No Variant' }}
                                                        </small>
                                                    </a>
                                                </td>
                                                <td class="unit text-center align-middle">{{ $item->quantity }}</td>
                                                <td class="rate text-right align-middle">{{ number_format($item->price, 2) }}</td>
                                                <td class="amnt text-right align-middle">{{ number_format($item->quantity * $item->price, 2) }}</td>
                                                <td class="disc text-right align-middle">
                                                    @php
                                                        $productDiscount = $item->discount ?? 0;
                                                        $couponDiscount = $item->coupon_discount ?? 0;
                                                        // Check for free delivery coupon by loading coupon relation if not loaded
                                                        $coupon = $order->relationLoaded('coupon') ? $order->coupon : \App\Models\Coupon::where('code', $order->coupon_code)->first();
                                                        $isFreeDelivery = $coupon && $coupon->specific_type === 'free_delivery' && $couponDiscount > 0;
                                                    @endphp
                                                    @if($productDiscount && $couponDiscount)
                                                        <span class="badge bg-info">Product: {{ number_format($productDiscount, 2) }}</span><br>
                                                        <span class="badge bg-success">
                                                            Coupon: Rs {{ number_format($couponDiscount, 2) }}
                                                            @if($isFreeDelivery)
                                                                <span class="badge bg-primary">Free Delivery</span>
                                                            @endif
                                                        </span>
                                                    @elseif($couponDiscount)
                                                        <span class="badge bg-success">
                                                            Coupon: Rs {{ number_format($couponDiscount, 2) }}
                                                            @if($isFreeDelivery)
                                                                <span class="badge bg-primary">Free Delivery</span>
                                                            @endif
                                                        </span>
                                                    @elseif($productDiscount)
                                                        <span class="badge bg-info">Product: {{ number_format($productDiscount, 2) }}</span>
                                                    @else
                                                        <span class="text-muted">0</span>
                                                    @endif
                                                </td>
                                                <td class="total text-right align-middle">
                                                    {{ number_format($item->quantity * $item->price - ($productDiscount + $couponDiscount), 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="3" class="table-light text-right"><strong>SUBTOTAL</strong></td>
                                            <td class="table-light text-right">Rs. {{ number_format($order->total_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td class="text-right"><strong>DISCOUNT</strong></td>
                                            <td colspan="2"></td>
                                            <td class="text-right">
                                                Rs. {{ number_format(($order->discount ?? 0) + ($order->coupon_discount ?? 0), 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="3" class="text-right"><strong>SHIPPING FEE</strong></td>
                                            <td class="text-right">Rs. {{ number_format($order->shipping_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="3" class="table-light text-right"><strong>GRAND TOTAL</strong></td>
                                            <td class="table-light text-right">Rs. {{ number_format($order->grand_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="3" class="text-right">
                                                <b>Total quantity:</b> {{ $order->order_items->sum('quantity') }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                @if($order->coupon_code)
                                <table class="table table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <td colspan="3">Discount</td>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>
                                            Coupon Discount:{{ $order->coupon_discount }}
                                            @php
                                                $coupon = $order->relationLoaded('coupon') ? $order->coupon : \App\Models\Coupon::where('code', $order->coupon_code)->first();
                                            @endphp
                                            @if($coupon && $coupon->specific_type === 'free_delivery')
                                                <span class="badge bg-primary">Free Delivery</span>
                                            @endif
                                        </td>
                                        <td>Coupon Used:{{ $order->coupon_code }}</td>
                                        <td>Other Discount:{{ $order->other_discount ?? 0 }}
                                        </td>
                                    </tr>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@stop

@section('css')
    <style>
        @media print {
            title {
                display: none;
            }

            body * {
                visibility: hidden;
            }

            #invoice,
            #invoice * {
                visibility: visible;
            }
        }
    </style>

@stop

@section('js')
    <script>
        function printInvoice() {
            var originalTitle = document.title;
            document.title = 'Invoice'; // Remove the title

            window.print(); // Trigger print

            document.title = originalTitle; // Restore the original title
        }
    </script>
@stop
