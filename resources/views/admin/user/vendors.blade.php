@extends('adminlte::page')

@section('title', 'Vendors')

@section('content_header')
    <h1>Vendors</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-vendors')
                            <div class="card-header">
                                <a href="{{ route('vendor.create') }}" class="btn btn-success">Create Vendor</a>
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
                                                    <th>Brand</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vendors as $vendor)
                                                    @php
                                                        if (
                                                            $vendor->hasRole('super-admin') &&
                                                            !auth()->user()->hasRole('super-admin')
                                                        ) {
                                                            continue;
                                                        }
                                                        if (
                                                            $vendor->hasRole('admin') &&
                                                            auth()->user()->cannot('read-admin')
                                                        ) {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <tr @if ($vendor->status != 'active') class="table-danger" @endif>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('read-vendors')
                                                                <a href="{{ route('vendor.show', $vendor->id) }}"
                                                                    class="btn btn-sm btn-primary mb-1" title="View Details">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endcan
                                                            @can('edit-vendors')
                                                                @if (!$vendor->hasRole('admin') || auth()->user()->can('edit-admin'))
                                                                    <a href="{{ route('vendor.edit', $vendor->id) }}"
                                                                        class="btn btn-sm btn-success mb-1" title="Edit">
                                                                        <i class="fa fa-pen"></i>
                                                                    </a>
                                                                @endif
                                                            @endcan
                                                            @can('delete-vendors')
                                                                @if (!$vendor->hasRole('admin') || auth()->user()->can('delete-admin'))
                                                                    <form method="post"
                                                                        action="{{ route('vendor.delete', $vendor->id) }}"
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
                                                                <a href="{{ route('vendor.activity', $vendor->id) }}"
                                                                    class="btn btn-sm btn-warning mb-1" title="View Activities">
                                                                    <i class="fa fa-list"></i>
                                                                </a>
                                                            @endcan
                                                            @can('edit-vendors')
                                                                @if (!$vendor->hasRole('super-admin'))
                                                                    @if ($vendor->status === 'active')
                                                                        <form method="POST" action="{{ route('user.deactivate', $vendor->id) }}" style="display:inline-block" class="deactivate-form">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button class="btn btn-sm btn-danger mb-1" title="Deactivate Vendor">
                                                                                <i class="fas fa-user-slash"></i>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <form method="POST" action="{{ route('user.activate', $vendor->id) }}" style="display:inline-block" class="activate-form">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button class="btn btn-sm btn-info mb-1" title="Activate Vendor">
                                                                                <i class="fas fa-user-check"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                @endif
                                                            @endcan

                                                        </td>
                                                        <td>{{ $vendor->name }}</td>
                                                        <td>{{ $vendor->email }}</td>
                                                        <td>{{ $vendor->phone }}</td>
                                                        <td>
                                                            <ul>
                                                                @foreach ($vendor->getRoleNames() as $role)
                                                                    <li>{{ ucfirst($role) }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            {{-- Show brand name if vendor --}}
                                                            @if ($vendor->hasRole('vendor'))
                                                                {{ optional($vendor->brand)->name ?? '—' }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($vendor->status == 'active')
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
                    text: "You are about to deactivate this vendor!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, deactivate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).off('submit').submit(); // Ensure the form is submitted after confirmation
                    }
                });
            });

            // SweetAlert confirmation for activate
            $('.activate-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to activate this vendor!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, activate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).off('submit').submit(); // Ensure the form is submitted after confirmation
                    }
                });
            });
        });
    </script>
@stop
