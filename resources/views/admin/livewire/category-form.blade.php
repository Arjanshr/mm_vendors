<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ isset($category) ? 'Edit category' : 'Create New Category' }}</h3>
    </div>
    <div class="card-body row">
        <div class="col-sm-12 text-red">
            {{$message}}
        </div>
    </div>
    <form method="POST"
        action="{{ isset($category) ? route('category.update', $category->id) : route('category.insert') }}"  enctype="multipart/form-data">
        @csrf
        @if (isset($category))
            @method('patch')
        @endif
        <div class="card-body row">
            <!-- Name -->
            <div class="form-group col-sm-6">
                <label for="name">Name*</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                    value="{{ isset($category) ? $category->name : old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Parent Category-->
            <div class="form-group col-sm-6">
                <label for="parent_id">Parent Category</label>
                <select id='parent_id' name="parent_id" class="form-control">
                    <option value="">Select a parent category</option>
                    @foreach ($parent_categories as $parent_category)
                        <option value="{{ $parent_category->id }}"
                            {{ (isset($category) && $category->parent_id == $parent_category->id) || old('parent_id') == $parent_category->id ? 'selected' : '' }}>
                            {{ $parent_category->name }}
                            @if ($parent_category->getParentTree() != '')
                                ({!! $parent_category->getParentTree() !!})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Description -->
            <div class="form-group col-sm-12">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ isset($category) ? $category->description : old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Status -->
            <div class="form-group col-sm-6">
                <label for="status">Status*</label>
                <select id='status' name="status" class="form-control" required>
                    <option value="">Select a status</option>
                    <option value="active"
                        {{ (isset($category) && $category->status == 'active') || old('status') == '1' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive"
                        {{ (isset($category) && $category->status == 'inactive') || old('status') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>
                @error('status')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-sm-6">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image"/>
                @if (isset($category) && $category->image)
                    <img src="{{ asset('storage/categories/' . $category->image) }}"class="img-fluid img-thumbnail"
                        style="height:100px" />
                @endif
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-sm-12">
                <input id="submit" type="submit" value="{{ isset($category) ? 'Edit' : 'Create' }}"
                    class="btn btn-primary" />
            </div>
    </form>
</div>
