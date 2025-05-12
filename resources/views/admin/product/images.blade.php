@extends('adminlte::page')

@section('title', $product->name . ' Images')

@section('content_header')
    <h1>{{ $product->name }} Images</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="text-warning">Recommended Image Size: </span><span class="text-danger">1000px x 1000px</span><br/>
                                        <span class="text-warning">Recommended Aspect Ratio: </span><span class="text-danger">1:1(Square)</span><br/>
                                        <span class="text-warning">Recommended Formats: </span><span class="text-danger">JPEG, PNG</span>
                                        <div id="dropzone">
                                            <form action="{{ route('product.image.insert', $product->id) }}" method="POST"
                                                class="dropzone" id="file-upload" enctype="multipart/form-data">
                                                @csrf
                                                <div class="fallback">
                                                    <input name="image" type="file" multiple />
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-sm-12">
                    <a href="{{route('products')}}" class="btn btn-primary"> Done</a>
                </div>
            </div>

        </div>

    </section>
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">

    <style>
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #1833FF;
            margin-top: 50px;
        }

        .dz-remove {
            display: inline-block !important;
            width: 1.2em;
            height: 1.2em;

            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 1000;

            font-size: 1.2em !important;
            line-height: 1.1em;

            text-align: center;
            font-weight: bold;
            border: 1px solid gray !important;
            border-radius: 1.2em;
            color: gray;
            background-color: white;
            opacity: .5;

        }

        .dz-remove:hover {
            text-decoration: none !important;
            opacity: 1;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script>
        // Initialize Dropzone
        var myDropZone = Dropzone.options.fileUpload = {
            paramName: "image", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            acceptedFiles: ".png, .jpg, .jpeg, .gif", // Allowed file types
            addRemoveLinks: true,
            dictRemoveFile: "×",
            init: function() {
                let myDropzone = this;
                var currentImages = {!! json_encode($product->getMedia()) !!}
                for (var key in currentImages) {
                    let mockFile = {
                        name: currentImages[key].file_name,
                        size: currentImages[key].size,
                        id: currentImages[key].uuid
                    };
                    myDropzone.displayExistingFile(mockFile, currentImages[key].original_url);
                };

                this.on("success", function(file, response) {
                    // console.log(response);
                });
            },
            removedfile: function(file) {
                file.previewElement.remove();
                $.ajax({
                    type: "POST",
                    url: "{{route('product.image.delete',$product->id)}}",
                    data: {
                        '_method': 'DELETE',
                        '_token': "{{csrf_token()}}",
                        'dataURL': file.dataURL,
                        'id': file.id,                        
                    },
                    success: function(response) {
                    }
                });
            }
        };

        $('.dropzone').sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '.dropzone',
            distance: 20,
            tolerance: 'pointer',
            stop: function() {
                newQueue = [];
                $('.dropzone .dz-preview .dz-filename [data-dz-name]').each(function(count, el) {
                    var name = el.innerHTML;
                    console.log(name)
                    $.ajax({
                    type: "POST",
                    url: "{{route('product.image.update',$product->id)}}",
                    data: {
                        '_method': 'PATCH',
                        '_token': "{{csrf_token()}}",
                        'name': name,
                        'count':count                        
                    },
                    success: function(response) {
                        console.log(response)
                    }
                });
                });
                myDropZone.files = newQueue;
            }
        });
    </script>
@stop
