@extends('adminlte::page')

@section('title', 'Activities')

@section('content_header')
    <h1>Activities</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                                    <th>Timestamp</th>
                                                    <th>Event</th>
                                                    <th>Subject Type</th>
                                                    <th>Subject Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activities as $activity)
                                                    <tr>
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('read-activities')
                                                            <a href="{{ route('user.activity.show', $activity->id) }}"
                                                                class="btn btn-sm btn-primary" title="View Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @endcan
                                                        </td>
                                                        <td>{{ $activity->created_at.'('.$activity->created_at->diffForHumans().')' }}</td>
                                                        <td>{{ $activity->event }}</td>
                                                        <td>{{ $activity->subject_type }}</td>
                                                        <td>{{ $activity->subject->name??'' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Timestamp</th>
                                                    <th>Event</th>
                                                    <th>Subject Type</th>
                                                    <th>Subject Name</th>                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{ $activities->links() }}

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
