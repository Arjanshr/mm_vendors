@extends('adminlte::page')

@section('title', $product->name . ' Variants')

@section('content_header')
    <h1>{{ $product->name }} Variants</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('edit-products')
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('product.variant.create', $product->id) }}" class="btn btn-success">Add Variant</a>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Variant SKU</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Options</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($variants as $variant)
                                                    <tr>
                                                        <td>{{ $variant['sku'] }}</td>
                                                        <td>Rs. {{ $variant['price'] }}</td>
                                                        <td>{{ $variant['stock'] }}</td>
                                                        <td>
                                                            <ul>
                                                                @foreach ($variant['options'] as $option)
                                                                    <li>{{ $option['specification'] }}: {{ $option['value'] }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('product.variant.edit', [$product->id, $variant['id']]) }}" class="btn btn-sm btn-primary" title="Edit Variant">Edit</a>

                                                            <form action="{{ route('product.variant.delete', [$product->id, $variant['id']]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger delete" title="Delete Variant">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
@stop

@section('js')
    <script>
        $(document.body).on('click', '.delete', function(event) {
            event.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $(document.body).on('click', '.deleteAll', function(event) {
            event.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@stop
