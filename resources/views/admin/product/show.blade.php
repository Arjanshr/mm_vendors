@extends('adminlte::page')

@section('title', $product->name ?? 'Products')

@section('content_header')
    <h1>{{ $product->name }}</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-product"></i>
                                Name
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $product->name }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Category
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                @foreach ($product->categories as $category)
                                    {{ $category->name }}{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Brand
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                {{ $product->brand ? $product->brand->name : 'NA' }}
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
                                {{ ucfirst($product->status) }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-product"></i>
                                Description
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {!! $product->description !!}
                            </blockquote>
                        </div>

                    </div>

                </div>


            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-product"></i>
                                Specifications
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                @foreach ($product->specifications as $specification)
                                    @if ($specification->specification)
                                        <p>
                                            {!! $specification->specification->name !!}:{!! $specification->value !!}
                                        </p>
                                    @endif
                                @endforeach
                            </blockquote>
                        </div>

                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-product"></i>
                                Features
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                @foreach ($product->features as $feature)
                                    <p>
                                        {!! $feature->feature !!}
                                    </p>
                                @endforeach
                            </blockquote>
                        </div>

                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-product"></i>
                                Images
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                @foreach ($product->getMedia() as $image)
                                    <img src="{{ $image->getUrl() }}" width="100" />
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
