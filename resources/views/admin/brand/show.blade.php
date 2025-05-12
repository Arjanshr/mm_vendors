@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-category"></i>
                                Name
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $category->name }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Parent
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                <a href="{{ route('category.show', $category->id) }}">
                                    {!! $category->getParentTree() !!}
                                </a>
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Status
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                {{ $category->status }}
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
