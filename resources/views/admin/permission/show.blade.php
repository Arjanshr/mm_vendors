@extends('adminlte::page')

@section('title', 'Permissions')

@section('content_header')
    <h1>Permissions</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-permission"></i>
                                Name
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $permission->name }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-permission"></i>
                                Guard
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $permission->guard_name }}
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
