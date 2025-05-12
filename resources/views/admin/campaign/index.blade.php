@extends('adminlte::page')

@section('title', 'Campaigns')

@section('content_header')
    <h1>Campaigns</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-campaigns')
                            <div class="card-header">
                                <a href="{{ route('campaigns.create') }}" class="btn btn-success">Create Campaign</a>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="sortable-campaigns" class="table table-bordered table-hover dataTable dtr-inline"
                                            aria-describedby="example2_info">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Banner</th>
                                                    <th>Status</th> <!-- New column for status -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($campaigns as $campaign)
                                                    <tr data-id="{{ $campaign->id }}">
                                                        <td width="20px">{{ $campaign->display_order }}</td> <!-- Display display_order -->
                                                        <td>
                                                            @can('edit-campaigns')
                                                                <a href="{{ route('campaigns.edit', $campaign->id) }}"
                                                                    class="btn btn-sm btn-success" title="Edit">
                                                                    <i class="fa fa-pen"></i>
                                                                </a>
                                                            @endcan
                                                            @can('delete-campaigns')
                                                                <form method="post"
                                                                    action="{{ route('campaigns.delete', $campaign->id) }}"
                                                                    style="display: initial;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="delete btn btn-danger btn-sm" type="submit"
                                                                        title="Delete" onclick="">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                            @can('edit-campaigns')
                                                                <a href="{{ route('campaigns.products', $campaign->id) }}"
                                                                    class="btn btn-sm btn-primary" title="Manage">
                                                                    <i class="fa fa-list"></i>
                                                                </a>
                                                            @endcan
                                                        </td>
                                                        <td>{{ $campaign->name }}</td>
                                                        <td>
                                                            @if($campaign->campaign_banner)
                                                                <img src="{{ asset('storage/' . $campaign->campaign_banner) }}" alt="Banner" width="100">
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $campaign->status ? 'badge-active' : 'badge-inactive' }}">
                                                                {{ $campaign->status ? 'Active' : 'Inactive' }}
                                                            </span>
                                                            @if($campaign->start_date && $campaign->end_date)
                                                                @php
                                                                    $now = \Carbon\Carbon::now();
                                                                    $start = \Carbon\Carbon::parse($campaign->start_date);
                                                                    $end = \Carbon\Carbon::parse($campaign->end_date);
                                                                @endphp
                                                                @if($now->between($start, $end))
                                                                    <span class="badge badge-success">Active</span> <!-- Green for Active -->
                                                                @elseif($now->isBefore($start))
                                                                    <span class="badge badge-warning">Upcoming</span> <!-- Yellow for Upcoming -->
                                                                @elseif($now->isAfter($end))
                                                                    <span class="badge badge-danger">Expired</span> <!-- Red for Expired -->
                                                                @endif
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
                                                    <th>Banner</th>
                                                    <th>Status</th> <!-- Footer column for status -->
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
    <style>
        .badge-active {
            background-color: #007bff;
            color: white;
        }
        .badge-inactive {
            background-color: #6c757d;
            color: white;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: black;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#sortable-campaigns tbody").sortable({
                update: function(event, ui) {
                    let order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.ajax({
                        url: "{{ route('campaigns.updateOrder') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Campaing Display Order updated successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update Campaign Display Order.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            }).disableSelection();
        });

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
        });
    </script>
@stop
