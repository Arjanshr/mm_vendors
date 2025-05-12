@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('add-categories')
                            <div class="card-header">
                                <a href="{{ route('category.create') }}" class="btn btn-success">Create Category</a>
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
                                                    <th>Parent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $category)
                                                    <tr>
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>
                                                            @can('read-categories')
                                                                <a href="{{ route('category.show', $category->id) }}"
                                                                    class="btn btn-sm btn-primary" title="View Details">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endcan
                                                            @can('edit-categories')
                                                                <a href="{{ route('category.edit', $category->id) }}"
                                                                    class="btn btn-sm btn-success" title="Edit">
                                                                    <i class="fa fa-pen"></i>
                                                                </a>
                                                            @endcan
                                                            @can('delete-categories')
                                                                <form method="post"
                                                                    action="{{ route('category.delete', $category->id) }}"
                                                                    style="display: initial;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="delete btn btn-danger btn-sm" type="submit"
                                                                        title="Delete" onclick="">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                            @can('browse-category-specifications')
                                                                <a href="{{ route('category-specifications', $category->id) }}"
                                                                    class="btn btn-sm btn-warning" title="Manage Category Specification List">
                                                                    <i class="fa fa-list"></i>
                                                                </a>
                                                            @endcan
                                                        </td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{!! $category->getParentTree() !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Parent</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{ $categories->links() }}
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
            $('#example2').DataTable();
            $('.dataTables_length').addClass('bs-select');
        })
    </script>
@stop
