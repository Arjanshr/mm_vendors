@extends('adminlte::page')

@section('title', 'Sliders')

@section('content_header')
    <h1>Sliders</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-sliders')
                            <div class="card-header">
                                <a href="{{ route('slider.create') }}" class="btn btn-success">Create Slider</a>
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
                                                    <th>Actions</th>
                                                    <th>Type</th>
                                                    <th>Linked URL</th>
                                                    <th>Display Order</th>
                                                    <th>Image</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sortable">
                                                @foreach ($sliders as $slider)
                                                    <tr data-id="{{ $slider->id }}">
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('edit-sliders')
                                                                <a href="{{ route('slider.edit', $slider->id) }}"
                                                                    class="btn btn-sm btn-success" title="Edit">
                                                                    <i class="fa fa-pen"></i>
                                                                </a>
                                                            @endcan
                                                            @can('delete-sliders')
                                                                <form method="post"
                                                                    action="{{ route('slider.delete', $slider->id) }}"
                                                                    style="display: initial;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="delete btn btn-danger btn-sm" type="submit"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                        <td>{{ $slider->type }}</td>
                                                        <td><a href="{{ $slider->link_url }}">Linked Url</a></td>
                                                        <td>{{ $slider->display_order }}</td>
                                                        <td>@if($slider->image)<img src="{{ asset('storage/sliders/'.$slider->image) }}" width="100" />@endif</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                {{ $sliders->links() }}
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
            $('#example2').DataTable();
            $('.dataTables_length').addClass('bs-select');

            // Enable sortable rows
            $("#sortable").sortable({
                update: function(event, ui) {
                    let order = [];
                    $('#sortable tr').each(function(index, element) {
                        order.push({
                            id: $(element).data('id'),
                            position: index + 1
                        });
                    });

                    // Send AJAX request to update order
                    $.ajax({
                        url: "{{ route('slider.updateOrder') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Order updated successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to update order!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        });
    </script>
@stop
