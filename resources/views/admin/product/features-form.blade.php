@extends('adminlte::page')

@section('title', 'Features')

@section('content_header')
    <h1>Features({{ $product->name }})</h1>
@stop

@section('content')


    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($feature) ? 'Edit Feature' : 'Create New Feature' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($feature) ? route('product.feature.update', [$feature->id]) : route('product.feature.insert', $product->id) }}">
                                @csrf
                                @if (isset($feature))
                                    @method('patch')
                                @endif
                                <div class="card-body row">
                                    <!-- Feature -->
                                    <div class="form-group col-sm-12">
                                        <label for="feature">Feature*</label>
                                        <textarea class="form-control" id="feature" name="feature" placeholder="Feature" rows="5"
                                         required>{{ isset($feature) ? $feature->feature : old('feature') }}</textarea>
                                        @error('feature')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <div class="form-group col-sm-12">
                                        <input id="submit" type="submit" value="{{ isset($feature) ? 'Edit' : 'Create' }}"
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
            $('#role').select2();
        });
    </script>
@stop
