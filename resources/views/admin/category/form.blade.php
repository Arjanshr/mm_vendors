@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@stop

@section('content')


    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        @if (isset($category))
                            @livewire('category-form', ['category' => $category])
                        @else
                            @livewire('category-form');
                        @endif
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#description'), {
                ckfinder: {
                    uploadUrl: '{{ route('category.create', ['_token' => csrf_token()]) }}'
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@stop
