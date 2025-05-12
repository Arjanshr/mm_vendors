<div>
    <div class="card-body row">
        <!-- Date -->
        <div class="form-group col-sm-6">
            <label for="order_date">Date*</label>
            <input type="date" class="form-control" id="order_date" name="order_date" placeholder="Date"
                value="{{ $order->order_date ?? (old('order_date') ?? date('Y-m-d')) }}" required>
            @error('order_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Customer -->
        <div class="form-group col-sm-6">
            <label for="customer_id">Customer</label>
            <select id='customer_id' name="customer_id" class="form-control" wire:model.live="customer">
                <option value="">Select a Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ (isset($order) && $order->customer_id == $customer->id) || old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="card-body row">
        <!-- Address -->
        @if ($addresses && $addresses->count() > 0)
            <div class="col-sm-12">
                <label for="address_type">Select an address</label>
                @foreach ($addresses as $address)
                    <input type="radio" class="btn-check" name="address_id" id="{{ $address->id }}"
                        autocomplete="off" {{ $address->is_default == 1 ? 'checked' : '' }} wire:model.live="address"
                        value={{ $address->id }}>
                    <label class="btn btn-secondary" for="{{ $address->id }}">
                        <b> {{ ucfirst($address->type) }}</b><br />
                        {{ $address->area->name }}<br />
                        {{ $address->location }}
                    </label>
                @endforeach
            </div>
        @endif
    </div>
    <div class="card-body row">
        <div class="form-group col-sm-6">
            <label for="address_type">Reciever's Name</label>
            <input type="text" class="form-control" id="reciever_name" name="reciever_name"
                placeholder="Reciever Name" wire:model.live="reciever_name" value="{{ old('reciever_name') }}">
            @error('reciever_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group col-sm-6">
            <label for="address_type">Address Type*</label>
            <select id='address_type' name="address_type" class="form-control" wire:model.live="address_type" required>
                <option value="">Select a Type</option>
                <option value="home"
                    {{ (isset($order) && $order->address_type == 'home') || old('address_type') == 'home' ? 'selected' : '' }}>
                    Home</option>
                <option
                    value="office"{{ (isset($order) && $order->address_type == 'office') || old('address_type') == 'office' ? 'selected' : '' }}>
                    Office</option>
                <option
                    value="others"{{ (isset($order) && $order->address_type == 'others') || old('address_type') == 'others' ? 'selected' : '' }}>
                    Others</option>
            </select>
            @error('address_type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="province_id">Province*</label>
            <select id='province_id' name="province_id" class="form-control" wire:model.live="province" required>
                <option value="">Select a Province</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>


            @error('province')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="city">City*</label>
            <select id='city' name="city_id" class="form-control" wire:model.live="city" required>
                <option value="">Select a City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="area">Area*</label>
            <select id='area' name="area_id" class="form-control" wire:model.live="area" required>
                <option value="">Select an Area</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select> @error('area')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" wire:model.live="location"
                placeholder="Eg:Near some land marks">
            @error('location')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number"
                wire:model.live="phone_number" placeholder="Phone Number">
            @error('phone_number')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" wire:model.live="email"
                placeholder="Email">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card-body row">
        <div class="form-group col-sm-6">
            <label for="address_type">Payment Type</label>
            <select id='payment_type' name="payment_type" class="form-control" required>
                <option value="">Select a payment Type</option>
                <option value="online"
                    {{ (isset($order) && $order->payment_type == 'online') || old('payment_type') == 'online' ? 'selected' : '' }}>
                    Online</option>
                <option value="cash"
                    {{ (isset($order) && $order->payment_type == 'cash') || old('payment_type') == 'cash' ? 'selected' : '' }}>
                    Cash</option>
                <option value="mixed"
                    {{ (isset($order) && $order->payment_type == 'mixed') || old('payment_type') == 'mixed' ? 'selected' : '' }}>
                    Mixed</option>
                <option value="others"
                    {{ (isset($order) && $order->payment_type == 'others') || old('payment_type') == 'others' ? 'selected' : '' }}>
                    Others</option>
            </select>
            @error('payment_type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-sm-6">
            <label for="address_type">Payment Status</label>
            <select id='customer_id' name="payment_status" class="form-control" required>
                <option value="">Select a payment Type</option>
                <option value="paid"
                    {{ (isset($order) && $order->payment_status == 'paid') || old('payment_status') == 'paid' ? 'selected' : '' }}>
                    Paid</option>
                <option value="unpaid"
                    {{ (isset($order) && $order->payment_status == 'unpaid') || old('payment_status') == 'unpaid' ? 'selected' : '' }}>
                    Unpaid</option>
                <option value="partially_paid"
                    {{ (isset($order) && $order->payment_status == 'partially_paid') || old('payment_status') == 'partially_paid' ? 'selected' : '' }}>
                    Partial</option>
            </select>
            @error('payment_status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="card-body row">

        <!-- Product -->
        <div class="form-group col-sm-12">
            <label for="select_product">Select a Product*</label>
            <div wire:ignore>
                <select class="form-control" id="select_product" wire:model.live="select_product">
                    <option value="">Select a Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('model')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <table class="table">
            <tr>
                <td>Name</td>
                <td>Rate</td>
                <td>Quantity</td>
                <td>Amount</td>
                <td>Discount</td>
                <td>Total</td>
                <td>Action</td>
            </tr>
            @if ($order_items)
                @foreach ($order_items as $index => $order_item)
                    <tr>
                        <input type="hidden" class="form-control" name="items[{{ $index }}][id]"
                            value="{{ $order_item['id'] }}" />

                        <td>{{ $order_item['name'] ?? 'NA' }}
                            <input type="hidden" class="form-control" name="items[{{ $index }}][name]"
                                value="{{ $order_item['name'] }}" />

                        </td>
                        <td>
                            {{ $order_item['rate'] ?? 'NA' }}
                            <input type="hidden" class="form-control" name="items[{{ $index }}][rate]"
                                value="{{ $order_item['rate'] }}" />

                        </td>
                        <td>
                            <input type="number" class="form-control" name="items[{{ $index }}][quantity]"
                                wire:change="change({{ $index }})"
                                wire:model.change="order_items.{{ $index }}.quantity"
                                value="{{ $order_item['quantity'] }}" min="1" />
                        </td>

                        <td>
                            {{ $order_item['amount'] ?? 'NA' }}
                            <input type="hidden" class="form-control" name="items[{{ $index }}][amount]"
                                value="{{ $order_item['amount'] }}" />
                        </td>
                        <td>
                            <input type="number" class="form-control" name="items[{{ $index }}][discount]"
                                wire:change="change({{ $index }})"
                                wire:model.change="order_items.{{ $index }}.discount" min="0"
                                value="{{ $order_item['discount'] }}" />
                        </td>
                        <td>
                            {{ $order_item['total'] ?? 'NA' }}
                            <input type="hidden" class="form-control" name="items[{{ $index }}][total]"
                                value="{{ $order_item['total'] }}" />
                        </td>

                        <td>
                            <a class="btn btn-danger" title="Delete Product"
                                wire:click="removeProduct({{ $index }})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <h5>Total Quantity: <b>{{ $total_quantity }}</b></h5>
                        <input type="hidden" name="total_quantity" value="{{ $total_quantity }}" readonly />
                    </td>
                    <td>
                        <h5>Total Amount: <b>{{ $total_amount }}</b></h5>
                        <input type="hidden" name="total_amount" value="{{ $total_amount }}" readonly />
                    </td>
                    <td>
                        <h5>Total Discount: <b>{{ $total_discount }}</b></h5>
                        <input type="hidden" name="total_discount" value="{{ $total_discount }}" readonly />
                    </td>
                    <td>
                        <h5>Shipping Price: <b>{{ $shipping_price }}</b></h5>
                        <input type="hidden" name="shipping_price" value="{{ $shipping_price }}" readonly />
                    </td>
                    <td>
                        <h5>Grand Total: <b>{{ $grand_total }}</b></h5>
                        <input type="hidden" name="grand_total" value="{{ $grand_total }}" readonly />
                    </td>
                    <td>
                    </td>
                </tr>
            @endif


        </table>

    </div>
    <div class="card-body row">
        <div class="form-group col-sm-6">
            <label for="coupon_code">Coupon Code</label>
            <input type="text" class="form-control" wire:model.live="coupon_code" name="coupon_code" readonly>
        </div>
        <div class="form-group col-sm-6">
            <label for="coupon_code">Coupon Discount</label>
            <input type="text" class="form-control" wire:model.live="coupon_discount" name="coupon_discount" readonly>
        </div>
    </div>
    {{-- <div class="card-body row">
        <div class="form-group col-sm-11">
            <label for="coupon_code">Coupon Code</label>
            <input type="text" class="form-control" wire:model.live="coupon_code" name="coupon_code">
            <input type="hidden" wire:model.live="coupon_discount" name="coupon_discount">
        </div>
        <div class="form-group col-sm-1">
            <br/>
            <button class="btn btn-sm btn-success" wire:click="applyCoupon" x-on:click.prevent>Apply</button>
        </div>
    </div> --}}

</div>
@script
    <script>
        window.loadSelect2 = () => {
            $('#select_product').select2({
                placeholder: '{{ __('Select a products') }}',
                allowClear: false
            });

        }

        $('#select_product').on('change', function() {
            var data = $('#select_product').select2("val");
            @this.set('select_product', data);
        });

        $wire.on('select2Hydrate', () => {
            loadSelect2();
        });
    </script>
@endscript
