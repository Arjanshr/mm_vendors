@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-users')
                            <div class="card-header">
                                <a href="{{ route('user.create') }}" class="btn btn-success">Create User</a>
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
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Roles</th>
                                                    <th>Brand</th> {{-- New --}}
                                                    <th>Status</th> {{-- New --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    @php
                                                        if (
                                                            $user->hasRole('super-admin') &&
                                                            !auth()->user()->hasRole('super-admin')
                                                        ) {
                                                            continue;
                                                        }
                                                        if (
                                                            $user->hasRole('admin') &&
                                                            auth()->user()->cannot('read-admin')
                                                        ) {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <tr @if($user->status!='active') class="table-danger" @endif>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('read-users')
                                                                <a href="{{ route('user.show', $user->id) }}"
                                                                    class="btn btn-sm btn-primary mb-1" title="View Details">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endcan

                                                            @can('edit-users')
                                                                @if (!$user->hasRole('admin') || auth()->user()->can('edit-admin'))
                                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                                        class="btn btn-sm btn-success mb-1" title="Edit">
                                                                        <i class="fa fa-pen"></i>
                                                                    </a>
                                                                @endif
                                                            @endcan

                                                            @can('delete-users')
                                                                @if (!$user->hasRole('admin') || auth()->user()->can('delete-admin'))
                                                                    <form method="post"
                                                                        action="{{ route('user.delete', $user->id) }}"
                                                                        style="display: inline;">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="delete btn btn-danger btn-sm mb-1"
                                                                            type="submit" title="Delete">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endcan

                                                            @can('read-activities')
                                                                <a href="{{ route('user.activity', $user->id) }}"
                                                                    class="btn btn-sm btn-warning mb-1" title="View Activities">
                                                                    <i class="fa fa-list"></i>
                                                                </a>
                                                            @endcan

                                                            @can('edit-users')
                                                                @if (!$user->hasRole('super-admin'))
                                                                    @if ($user->status === 'active')
                                                                        <form method="POST" action="{{ route('user.deactivate', $user->id) }}" style="display:inline-block" class="deactivate-form">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button class="btn btn-sm btn-danger mb-1" title="Deactivate User">
                                                                                <i class="fas fa-user-slash"></i>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <form method="POST" action="{{ route('user.activate', $user->id) }}" style="display:inline-block" class="activate-form">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button class="btn btn-sm btn-info mb-1" title="Activate User">
                                                                                <i class="fas fa-user-check"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                @endif
                                                            @endcan

                                                        </td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>
                                                            <ul>
                                                                @foreach ($user->getRoleNames() as $role)
                                                                    <li>{{ ucfirst($role) }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            {{-- Show brand name if vendor --}}
                                                            @if ($user->hasRole('vendor'))
                                                                {{ optional($user->brand)->name ?? '—' }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->status == 'active')
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                                <span class="badge badge-secondary">Inactive</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Roles</th>
                                                    <th>Brand</th>
                                                    <th>Status</th>
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
        $(document).ready(function() {
            $('#example2').DataTable({
                "pageLength": 100
            });
            $('.dataTables_length').addClass('bs-select');

            // SweetAlert confirmation for deactivate
            $('.deactivate-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to deactivate this user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, deactivate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // SweetAlert confirmation for activate
            $('.activate-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to activate this user!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, activate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop
