<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ isset($expense) ? 'Edit expense' : 'Create New Expense' }}</h3>
    </div>
    <form method="POST" action="{{ isset($expense) ? route('expense.update', $expense->id) : route('expense.insert') }}"
        enctype="multipart/form-data">
        @csrf
        @if (isset($expense))
            @method('patch')
        @endif
        <div class="card-body row">

            <!-- User -->
            <div class="form-group col-sm-4">
                <label for="user_id">User</label>
                <select id='user_id' name="user_id" class="form-control" wire:model="user_id">
                    <option value="">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Name -->
            <div class="form-group col-sm-4">
                <label for="name">Name*</label>
                <small>Select a user or enter a name of user</small>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                    value="{{ old('name', $user_name) }}" required {{ $read_only ? 'readonly' : '' }}>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date -->
            <div class="form-group col-sm-4">
                <label for="category_id">Date*</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Date"
                    value="{{ $expense->date??old('date') }}" required >
                    @error('date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            </div>

            <!-- Category -->
            <div class="form-group col-sm-3">
                <label for="category_id">Category*</label>
                <select id='category_id' name="category_id" class="form-control" required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (isset($expense) && $expense->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Amount -->
            <div class="form-group col-sm-3">
                <label for="amount">Amount*</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                    placeholder="Amount" value="{{ isset($expense) ? $expense->amount : old('amount') }}" required>
                @error('amount')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!--  Description -->
            <div class="form-group col-sm-3">
                <label for="description">Description</label>
                <textarea id="description" class="form-control w-full" name="description" rows="4">{{ isset($expense) ? $expense->getRawOriginal('description') : old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!--  Atachment -->
            <div class="form-group col-sm-3">
                <label for="description">Attachment*</label>
                <input type="file" class="form-control" name="attachment" required/>
                @if (isset($expense) && $expense->attachment)
                    <img src="{{ asset('storage/expenses/' . $expense->attachment) }}"class="img-fluid img-thumbnail"
                        style="height:100px" />
                @endif
                @error('attachment')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-sm-12">
                <input type="submit" value="{{ isset($expense) ? 'Edit' : 'Create' }}" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>
