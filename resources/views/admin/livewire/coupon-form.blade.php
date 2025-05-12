<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($coupon) ? route('coupons.update', $coupon->id) : route('coupons.insert') }}" method="POST">
        @csrf
        @if (isset($coupon))
            @method('patch')
        @endif
        <div class="card-body row">
            <!-- Coupon Code -->
            <div class="form-group col-sm-12">
                <label for="code">Coupon Code*</label>
                <input type="text" class="form-control" id="code" wire:model="code" placeholder="Coupon Code"
                    name="code" required>
                @error('code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Discount Type & Discount Value -->
            <div class="form-group col-sm-6">
                <label for="type">Discount Type*</label>
                <select wire:model="type" class="form-control" name="type" required>
                    <option value="">Select Discount Type</option>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
                @error('type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-sm-6">
                <label for="discount">Discount Value*</label>
                <input type="number" class="form-control" name="discount" wire:model="discount"
                    placeholder="Discount Value" required>
                @error('discount')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Max Uses -->
            <div class="form-group col-sm-6">
                <label for="max_uses">Max Uses</label>
                <input type="number" class="form-control" wire:model="max_uses" name="max_uses" placeholder="Max Uses">
                @error('max_uses')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Expiry Date -->
            <div class="form-group col-sm-6">
                <label for="expires_at">Expiration Date</label>
                <input type="datetime-local" class="form-control" wire:model="expires_at" name="expires_at">
                @error('expires_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Specific Type (Category, Brand, Product, or Free Delivery) -->
            <div class="form-group col-sm-6">
                <label for="specific_type">Coupon Specific Type*</label>
                <select wire:model.live="specific_type" class="form-control" name="specific_type" required>
                    <option value="normal">Normal</option>
                    <option value="category">Category Specific</option>
                    <option value="brand">Brand Specific</option>
                    <option value="product">Product Specific</option>
                    <option value="free_delivery">Free Delivery</option>
                </select>
                @error('specific_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Conditional Category Selection -->
            <div class="form-group col-sm-6">
                @if ($specific_type == 'category')
                    <label for="category_id">Categories</label>
                    <select id="category_id" wire:model.live="category_ids" class="form-control" name="specific_ids[]"
                        multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, $category_ids) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_ids')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif

                <!-- Conditional Brand Selection -->
                @if ($specific_type == 'brand')
                    <label for="brand_id">Brands</label>
                    <select id="brand_id" wire:model.live="brand_ids" class="form-control" name="specific_ids[]" multiple>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ in_array($brand->id, $brand_ids) ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_ids')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif

                <!-- Conditional Product Selection -->
                @if ($specific_type == 'product')
                    <label for="product_id">Products</label>
                    <select id="product_id" wire:model.live="product_ids" class="form-control" name="specific_ids[]"
                        multiple>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ in_array($product->id, $product_ids) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_ids')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>

            <!-- Is User Specific? -->
            <div class="form-group col-sm-6">
                <label for="is_user_specific">Is User Specific?</label>
                <input type="checkbox" id="is_user_specific" wire:model.live="is_user_specific" name="is_user_specific">
            </div>

            <!-- User Selection -->
            <div class="form-group col-sm-6">
                @if ($is_user_specific)
                    <label for="user_id">Select Users</label>
                    <select id="user_id" wire:model.live="user_ids" class="form-control" name="user_ids[]" multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ in_array($user->id, $user_ids) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_ids')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>


            <!-- Status -->
            <div class="form-group col-sm-6">
                <label for="status">Status*</label>
                <select wire:model="status" class="form-control" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @error('status')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-primary">Save Coupon</button>
            </div>
        </div>
    </form>
</div>

@script
    <script>
        document.addEventListener('livewire:navigated', function() {
            loadSelect2();
        });

        function loadSelect2() {
            // Initialize select2 for user, category, brand, and product fields
            $('#user_id').select2({
                placeholder: 'Select Users',
                allowClear: true
            }).on('change', function() {
                Livewire.dispatch('updateUserIds', {
                    value: $(this).val()
                });
            });

            $('#category_id').select2({
                placeholder: 'Select Categories',
                allowClear: true
            }).on('change', function() {
                Livewire.dispatch('updateCategoryIds', {
                    value: $(this).val()
                });
            });

            $('#brand_id').select2({
                placeholder: 'Select Brands',
                allowClear: true
            }).on('change', function() {
                Livewire.dispatch('updateBrandIds', {
                    value: $(this).val()
                });
            });

            $('#product_id').select2({
                placeholder: 'Select Products',
                allowClear: true
            }).on('change', function() {
                Livewire.dispatch('updateProductIds', {
                    value: $(this).val()
                });
            });
        }

        Livewire.on('select2Hydrate', function() {
            setTimeout(loadSelect2, 500);
        });
    </script>
@endscript
