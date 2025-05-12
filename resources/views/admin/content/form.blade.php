@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')


    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($role) ? 'Edit role' : 'Create New Role' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($role) ? route('role.update', $role->id) : route('role.insert') }}">
                                @csrf
                                @if (isset($role))
                                    @method('patch')
                                @endif
                                <!-- Name -->
                                <div class="card-body row">
                                    <div class="form-group col-sm-12">
                                        <label for="name">Name*</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" value="{{ isset($role) ? $role->name : old('name') }}"
                                            {{ isset($role) && ($role->name == 'super-adimn' || $role->name == 'admin' ||$role->name == 'customer')?'readonly':''}} required rea>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if (isset($permissions) && count($permissions) > 0)
                                        @foreach ($permissions as $index => $module)
                                            @php
                                                if (!auth()->user()->hasRole('super-admin')&&($index == 'permissions' || $index == 'settings'))
                                                {
                                                    continue;
                                                }
                                            @endphp
                                            <div class="col-sm-12">
                                                <div class="head" style="margin-left:15px">
                                                    <input class="form-check-input check-all" id="{{ $index }}"
                                                        type="checkbox" />
                                                    <h5>
                                                        {{ ucfirst($index) }}
                                                    </h5>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    @foreach ($module as $permission)
                                                        <div class="form-group col-sm-3 form-check">

                                                            <input class="form-check-input {{ $index }}"
                                                                type="checkbox" name="permissions[]"
                                                                id="{{ $permission->id }}" value="{{ $permission->id }}"
                                                                {{ (isset($role) && in_array($permission->id, $role->permissions->pluck('id')->toArray())) ||
                                                                in_array($permissions, old('permissions') ?? [])
                                                                    ? 'checked'
                                                                    : '' }}>
                                                            <label class="form-check-label"
                                                                for="{{ $permission->id }}">{{ ucfirst($permission->name) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <hr />
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="form-group col-sm-6">
                                        <input type="submit" value="{{ isset($role) ? 'Edit' : 'Create' }}"
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
        $(".check-all").change(function() {
            var model = $(this).attr('id')
            if ($(this).is(":checked")) {
                $("." + model).prop('checked', true);
            } else {
                $("." + model).prop('checked', false);
            }
        });
    </script>
@stop
