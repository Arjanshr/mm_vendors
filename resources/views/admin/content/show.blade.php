@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Roles</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-role"></i>
                                Name
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $role->name }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-role"></i>
                                Guard
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $role->guard_name }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-role"></i>
                                Permissions
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                @foreach($role->permissions as $permission)
                                {{$permission->name}}{{!$loop->last?', ':''}}
                                @endforeach
                            </blockquote>
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

@stop
