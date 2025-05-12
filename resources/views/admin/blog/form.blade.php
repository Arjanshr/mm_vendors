@extends('adminlte::page')

@section('title', 'Blogs')

@section('content_header')
    <h1>Blogs</h1>
@stop

@section('content')


    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($blog) ? 'Edit Blog' : 'Create New Blog' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($blog) ? route('blog.update', $blog->id) : route('blog.insert') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if (isset($blog))
                                    @method('patch')
                                @endif
                                <div class="card-body row">
                                    <!-- Title -->
                                    <div class="form-group col-sm-12">
                                        <label for="tite">Title*</label>
                                        <input type="text" class="form-control" id="tite" name="title"
                                            placeholder="Title" value="{{ isset($blog) ? $blog->title : old('title') }}"
                                            required>
                                        @error('title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Content -->
                                    <div class="form-group col-sm-12">
                                        <label for="content">Content</label>
                                        <textarea id="content" name="content">{{ isset($blog) ? $blog->content : old('content') }}</textarea>
                                        @error('content')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--  Image -->
                                    <div class="form-group col-sm-6">
                                        <label for="image">Image*</label>
                                        <input type="file" class="form-control" name="image" />
                                        @if (isset($blog) && $blog->image)
                                            <img src="{{ asset('storage/blogs/' . $blog->image) }}"class="img-fluid img-thumbnail"
                                                style="height:100px" />
                                        @endif
                                        @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group col-sm-6">
                                        <label for="status">Status*</label>
                                        <select id='status' name="status" class="form-control" required>
                                            <option value="">Select a status</option>
                                            <option value="publish"
                                                {{ (isset($blog) && $blog->status == 'publish') || old('status') == 'publish' ? 'selected' : '' }}>
                                                Publish
                                            </option>
                                            <option value="unpublish"
                                                {{ (isset($blog) && $blog->status == 'unpublish') || old('status') == 'unpublish' ? 'selected' : '' }}>
                                                Unpublish
                                            </option>

                                        </select>
                                        @error('status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <input id="submit" type="submit" value="{{ isset($blog) ? 'Edit' : 'Create' }}"
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#content'), {
                ckfinder: {
                    uploadUrl: '{{ route('category.create', ['_token' => csrf_token()]) }}'
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@stop
