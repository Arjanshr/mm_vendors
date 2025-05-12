@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Permissions</h1>
@stop

@section('content')


    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($permission) ? 'Edit permission' : 'Create New Permission' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($permission) ? route('permission.update', $permission->id) : route('permission.insert') }}">
                                @csrf
                                @if (isset($permission))
                                    @method('patch')
                                @endif
                                <!-- Name -->
                                <div class="card-body row">
                                    <div class="form-group col-sm-12">
                                        <label for="name">Name*</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" value="{{ isset($permission) ? $permission->name : old('name') }}"
                                            required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(!isset($permission))
                                    <div class="form-group col-sm-2">
                                        <label for="browse">Browse</label>
                                        <input type="checkbox" name="fields[]" id="browse" value="browse">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="read">Read</label>
                                        <input type="checkbox" name="fields[]" id="read" value="read">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="add">Add</label>
                                        <input type="checkbox" name="fields[]" id="add" value="add">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="edit">Edit</label>
                                        <input type="checkbox" name="fields[]" id="edit" value="edit">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="delete">Delete</label>
                                        <input type="checkbox" name="fields[]" id="delete" value="delete">
                                    </div>
                                    @endif
                                    <div class="form-group col-sm-6">
                                        <input type="submit" value="{{ isset($permission) ? 'Edit' : 'Create' }}"
                                            class="btn btn-primary" />
                                    </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </section>
    </div>


@stop

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#permission').select2();
        });
    </script>

@stop
