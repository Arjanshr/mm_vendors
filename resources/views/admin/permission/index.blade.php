@extends('adminlte::page')

@section('title', 'Permissions')

@section('content_header')
    <h1>Permissions</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-permissions')
                            <div class="card-header">
                                <a href="{{ route('permission.create') }}" class="btn btn-success">Create Permission</a>
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
                                                    <th>Name</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($permissions as $permission)
                                                    <tr>
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('read-permissions')
                                                            <a href="{{ route('permission.show', $permission->id) }}"
                                                                class="btn btn-sm btn-primary" title="View Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @endcan
                                                            @can('edit-permissions')
                                                            <a href="{{ route('permission.edit', $permission->id) }}"
                                                                class="btn btn-sm btn-success" title="Edit">
                                                                <i class="fa fa-pen"></i>
                                                            </a>
                                                            @endcan
                                                            @can('delete-permissions')
                                                            <form method="post"
                                                                action="{{ route('permission.delete', $permission->id) }}"
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
                                                        <td>{{ $permission->name }}</td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{ $permissions->links() }}
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
            var form =  $(this).closest("form");
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
    </script>
@stop
