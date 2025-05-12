@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <h1>
        Products</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-contents')
                            <div class="card-header">
                                <form action="{{ route('contents.insert', $content_type) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-11">
                                            <select class="form-control" id="product_ids" name="product_ids[]" multiple>
                                                @foreach ($all_products as $all_product)
                                                    <option value="{{ $all_product->id }}">{{ $all_product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-success">Add</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline"
                                            aria-describedby="example2_info">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    {{-- <th>Order</th>
                                                    <th>Status</th> --}}
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>{{ $product->product->name }}</td>
                                                        {{-- <td>{{ $product->display_order }}</td>
                                                        <td>{{ $product->status }}</td> --}}
                                                        <td>
                                                            @can('delete-contents')
                                                                <form method="post"
                                                                    action="{{ route('content.delete', [$content_type,$product->id]) }}"
                                                                    style="display: initial;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="delete btn btn-danger btn-sm" type="submit"
                                                                        title="Delete" onclick="">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    {{-- <th>Order</th>
                                                    <th>Status</th> --}}
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
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
                    form.submit()
                }
            })
        });

        $(document).ready(function() {
            $('#product_ids').select2();
        });
    </script>
@stop
