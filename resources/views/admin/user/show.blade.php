@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Name
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $user->name }}
                            </blockquote>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-envelope"></i>
                                Email
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>

                                {{ $user->email }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-phone"></i>
                                Phone
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $user->phone}}
                            </blockquote>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-transgender"></i>
                                Gender
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                {{ $user->gender }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar"></i>
                                Date of birth
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $user->dob }}
                            </blockquote>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i>
                                Roles
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                @foreach ($user->getRoleNames() as $roles)
                                    {{ $roles }}{{ $loop->last ? '' : ', ' }}
                                @endforeach
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i>
                                Address
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                               {!!$user->address!!}
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
