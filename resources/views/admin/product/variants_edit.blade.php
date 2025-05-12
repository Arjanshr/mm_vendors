@extends('adminlte::page')

@section('title', 'Edit Variant')

@section('content_header')
    <h1>Edit Variant for {{ $product->name }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('product.variant.update', [$product->id, $variant->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="variant-sku">SKU</label>
                    <input type="text" class="form-control" id="variant-sku" value="{{ $variant->sku }}" disabled>
                </div>

                <div class="form-group">
                    <label for="variant-price">Price</label>
                    <input type="number" name="price" class="form-control" id="variant-price" 
                           value="{{ old('price', $variant->price) }}" required>
                </div>

                <div class="form-group">
                    <label for="variant-stock">Stock</label>
                    <input type="number" name="stock_quantity" class="form-control" id="variant-stock" 
                           value="{{ old('stock_quantity', $variant->stock_quantity) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('product.variants', $product->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </section>
@stop
