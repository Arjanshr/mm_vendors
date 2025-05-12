<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ isset($product) ? 'Edit Product' : 'Create New Product' }}</h3>
    </div>
    <form method="POST" action="{{ isset($product) ? route('product.update', $product->id) : route('product.insert') }}">
        @csrf
        @if (isset($product))
            @method('patch')
        @endif
        <div class="card-body">
            <div class="row">
                <!-- Name -->
                <div class="form-group col-md-6">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                        value="{{ isset($product) ? $product->name : old('name') }}" wire:model="name" required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Price -->
                <div class="form-group col-md-6">
                    <label for="price">Price*</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price"
                        value="{{ isset($product) ? $product->price : old('price') }}" wire:model="price" required>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Description -->
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3">{{ isset($product) ? $product->description : old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Categories -->
                <div class="form-group col-md-6">
                    <label for="category_id">Categories</label>
                    <select name="category_id[]" id="categories" class="form-control" multiple required>
                        <option value="">--select--</option>
                        @if (isset($categories))
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (isset($product) &&
                                            $product->categories()->where('category_id', $category->id)->exists()) {{ 'selected' }} @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group col-md-6">
                    <label for="status">Status*</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="">Select a status</option>
                        <option value="publish"
                            {{ (isset($product) && $product->status == 'publish') || old('status') == 'publish' ? 'selected' : '' }}>
                            Publish
                        </option>
                        <option value="unpublish"
                            {{ (isset($product) && $product->status == 'unpublish') || old('status') == 'unpublish' ? 'selected' : '' }}>
                            Unpublish
                        </option>
                    </select>
                    @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Alt Text -->
                <div class="form-group col-md-6">
                    <label for="alt_text">Alt Text*</label>
                    <input type="text" class="form-control" id="alt_text" name="alt_text" placeholder="Alt Text"
                        value="{{ isset($product) ? $product->alt_text : old('alt_text') }}" wire:model="alt_text" required>
                    @error('alt_text')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keywords -->
                <div class="form-group col-md-6">
                    <label for="keywords">Keywords</label>
                    <div class="tags-container mb-2">
                        @if (is_array($keywords))
                            @foreach ($keywords as $keyword)
                                <span class="badge badge-primary">{{ $keyword }}</span>
                            @endforeach
                        @endif
                    </div>
                    <textarea class="form-control" id="keywords" name="keywords" rows="3" placeholder="Enter keywords separated by commas">{{ is_array($keywords) ? implode(',', $keywords) : $keywords }}</textarea>
                    @error('keywords')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group text-center">
                <input id="submit" type="submit" value="{{ isset($product) ? 'Edit' : 'Create' }}" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const keywordsInput = document.querySelector('#keywords');
        const tagsContainer = document.querySelector('.tags-container');

        function updateTags() {
            const keywords = keywordsInput.value.split(',').map(kw => kw.trim()).filter(kw => kw);
            tagsContainer.innerHTML = '';
            keywords.forEach(keyword => {
                const badge = document.createElement('span');
                badge.className = 'badge badge-primary';
                badge.textContent = keyword;
                badge.style.marginRight = '5px';
                badge.style.marginBottom = '5px';
                tagsContainer.appendChild(badge);
            });
        }

        keywordsInput.addEventListener('input', function (e) {
            if (e.inputType === 'insertText' && e.data === ',') {
                updateTags();
            }
        });

        keywordsInput.addEventListener('blur', updateTags);
    });
</script>
