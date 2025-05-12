@extends('adminlte::page')

@section('title', 'Popup Banners')

@section('content_header')
    <h1>Popup Banners</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($popupBanner->id)
                                <!-- Form for editing the Popup Banner -->
                                <form action="{{ route('popup-banners.update', $popupBanner->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')

                                    <!-- Display Validation Errors -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Image and Toggle in Same Row -->
                                    <div class="form-group d-flex align-items-center">
                                        <!-- Current Image Display -->
                                        <div class="mr-3">
                                            <img id="imagePreview"
                                                src="{{ $popupBanner->image_url ? Storage::url($popupBanner->image_url) : 'https://via.placeholder.com/150' }}"
                                                alt="Current Image" class="img-thumbnail" width="150">
                                        </div>

                                        <!-- Toggle Button for Display Popup -->
                                        <div>
                                            <label for="is_active" class="d-block">Display Popup</label>
                                            <div class="custom-control custom-switch">
                                                <!-- Hidden input to ensure a value is always submitted -->
                                                <input type="hidden" name="is_active" value="0">

                                                <input type="checkbox" class="custom-control-input" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ $popupBanner->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">Toggle On/Off</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label for="image_url">Upload New Popup Banner</label>
                                        <input type="file" class="form-control @error('image_url') is-invalid @enderror"
                                            name="image_url" id="image_url" accept="image/*">
                                        @error('image_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            @endif
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
    <script>
        $(document).ready(function() {
            // Update Image Preview When File Selected
            $('#image_url').change(function(event) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(event.target.files[0]);
            });

            // Ensure the toggle switch label updates dynamically
            $('#is_active').change(function() {
                if ($(this).is(':checked')) {
                    $(this).next('label').text('On');
                } else {
                    $(this).next('label').text('Off');
                }
            });
        });
    </script>
@stop
