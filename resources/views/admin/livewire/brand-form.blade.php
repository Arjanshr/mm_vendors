<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ isset($brand) ? 'Edit brand' : 'Create New Brand' }}</h3>
    </div>
    <div class="card-body row">
        <div class="col-sm-12 text-red">
            {{ $message }}
        </div>
    </div>
    <form method="POST" action="{{ isset($brand) ? route('brand.update', $brand->id) : route('brand.insert') }}"
        enctype="multipart/form-data">
        @csrf
        @if (isset($brand))
            @method('patch')
        @endif
        <div class="card-body row">
            <!-- Name -->
            <div class="form-group col-sm-12">
                <label for="name">Name*</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                    value="{{ isset($brand) ? $brand->name : old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Description -->
            <div class="form-group col-sm-12">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ isset($brand) ? $brand->description : old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!--  Image -->
            <div class="form-group col-sm-12">
                <label for="image">Image*</label>
                <input type="file" class="form-control" name="image" {{ isset($brand) ? '' : 'required' }} />
                @if (isset($brand) && $brand->image)
                    <img src="{{ asset('storage/brands/' . $brand->image) }}"class="img-fluid img-thumbnail"
                        style="height:100px" />
                @endif
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-sm-12">
                <input id="submit" type="submit" value="{{ isset($brand) ? 'Edit' : 'Create' }}"
                    class="btn btn-primary" />
            </div>
    </form>
</div>
