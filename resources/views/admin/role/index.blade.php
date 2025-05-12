@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Roles</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-roles')
                            <div class="card-header">
                                <a href="{{ route('role.create') }}" class="btn btn-success">Create Role</a>
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
                                                    <th>Permissions</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                    <tr>
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('read-roles')
                                                                <a href="{{ route('role.show', $role->id) }}"
                                                                    class="btn btn-sm btn-primary" title="View Details">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endcan
                                                            @if ($role->name!='super-admin')
                                                                @can('edit-roles')
                                                                    <a href="{{ route('role.edit', $role->id) }}"
                                                                        class="btn btn-sm btn-success" title="Edit">
                                                                        <i class="fa fa-pen"></i>
                                                                    </a>
                                                                @endcan
                                                            @endif
                                                            @if ($role->name!='super-admin'&&$role->name!='admin'&&$role->name!='customer')
                                                                @can('delete-roles')
                                                                    <form method="post"
                                                                        action="{{ route('role.delete', $role->id) }}"
                                                                        style="display: initial;">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="delete btn btn-danger btn-sm"
                                                                            type="submit" title="Delete" onclick="">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            @endif
                                                        </td>
                                                        <td>{{ $role->name }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#role-modal-{{ $role->id }}">
                                                                View All Permissions
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="role-modal-{{ $role->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Permissions</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if (isset($permissions) && count($permissions) > 0)
                                                                        @foreach ($permissions as $index => $module)
                                                                            @php
                                                                                if (
                                                                                    !auth()
                                                                                        ->user()
                                                                                        ->hasRole('super-admin') &&
                                                                                    ($index == 'permissions' || $index == 'settings')
                                                                                ) {
                                                                                    continue;
                                                                                }
                                                                            @endphp
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="head"
                                                                                        style="margin-left:15px">
                                                                                        {{ ucfirst($index) }}
                                                                                    </div>
                                                                                    <hr />
                                                                                    <div class="row">
                                                                                        @foreach ($module as $permission)
                                                                                            <div
                                                                                                class="form-group col-sm-6 form-check">
                                                                                                <small>

                                                                                                    @if (
                                                                                                        (isset($role) && in_array($permission->id, $role->permissions->pluck('id')->toArray())) ||
                                                                                                            in_array($permissions, old('permissions') ?? []) ||
                                                                                                            $role->name == 'super-admin')
                                                                                                        <i
                                                                                                            class="fa fa-check text-green"></i>
                                                                                                    @else
                                                                                                        <i
                                                                                                            class="fa fa-times text-red"></i>
                                                                                                    @endif
                                                                                                    {{ ucfirst($permission->name) }}
                                                                                                </small>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                    <hr />
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Permissions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{ $roles->links() }}
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
    </script>
@stop
