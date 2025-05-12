@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>{{ isset($user) ? 'Edit User' : 'Create New User' }}</h1>
@stop

@section('content')
    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($user) ? 'Edit User' : 'Create New User' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($user) ? route('user.update', $user->id) : route('user.insert') }}">
                                @csrf
                                @if (isset($user))
                                    @method('patch')
                                @endif
                                <div class="card-body row">
                                    <!-- Name -->
                                    <div class="form-group col-sm-12">
                                        <label for="name">Name*</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" value="{{ isset($user) ? $user->name : old('name') }}"
                                            required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Email -->
                                    <div class="form-group col-sm-4">
                                        <label for="email">Email*</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" value="{{ isset($user) ? $user->email : old('email') }}">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Phone -->
                                    <div class="form-group col-sm-4">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Phone" value="{{ isset($user) ? $user->phone : old('phone') }}">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- DOB (Optional) -->
                                    <div class="form-group col-sm-4">
                                        <label for="dob">Date of birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                            placeholder="Date of birth"
                                            value="{{ isset($user) ? $user->getRawOriginal('dob') : old('dob') }}">
                                        @error('dob')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Gender (Optional) -->
                                    <div class="form-group col-sm-4">
                                        <label>Gender</label>
                                        <br />
                                        <input type="radio" id="male" name="gender" value="male"
                                            {{ (isset($user) && strtolower($user->gender) == 'male') || old('gender') == 'male' ? 'checked' : '' }}>
                                        <label for="male">Male</label><br>

                                        <input type="radio" id="female" name="gender" value="female"
                                            {{ (isset($user) && strtolower($user->gender) == 'female') || old('gender') == 'female' ? 'checked' : '' }}>
                                        <label for="female">Female</label><br>

                                        @error('gender')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Address -->
                                    <div class="form-group col-sm-4">
                                        <label for="address">Address</label>
                                        <textarea id="address" class="form-control w-full" name="address" rows="4">{{ isset($user) ? $user->getRawOriginal('address') : old('address') }}</textarea>
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Role -->
                                    <div class="form-group col-sm-4" id="role_field">
                                        <label for="role">Role*</label>
                                        <select id="role" class="form-control" name="role[]" multiple="multiple">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ (isset($user) && in_array($role, $user->getRoleNames()->toArray())) || in_array($role, old('role') ?? [])
                                                        ? 'selected'
                                                        : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Brand -->
                                    <div class="form-group col-sm-4" id="brand_field" style="display: none;">
                                        <label for="brand_id">Select Brand for Vendor*</label>
                                        <select class="form-control" name="brand_id" id="brand_id">
                                            <option value="">-- Select Brand --</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ (isset($user) && $user->brand_id == $brand->id) || old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if (isset($user))
                                        @can('change-user-password')
                                            <!-- Password -->
                                            <div class="form-group col-sm-4">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control" id="password" name="password"
                                                    placeholder="Password">
                                                @error('password')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endcan
                                    @endif
                                    <!-- Submit Button -->
                                    <div class="form-group col-sm-12">
                                        <input id="submit" type="submit" value="{{ isset($user) ? 'Edit' : 'Create' }}"
                                            class="btn btn-primary" />
                                    </div>
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

            function toggleFields() {
                const isVendorCreation = "{{ request()->routeIs('vendor.create') }}";
                if (isVendorCreation) {
                    $('#role_field').hide();
                    $('#role').val(['vendor']).trigger('change');
                    $('#brand_field').show();
                } else {
                    $('#role_field').show();
                    const selectedRoles = $('#role').val();
                    if (selectedRoles && selectedRoles.includes('vendor')) {
                        $('#brand_field').show();
                    } else {
                        $('#brand_field').hide();
                        $('#brand_id').val('');
                    }
                }
            }

            // Initial check
            toggleFields();

            // On role change
            $('#role').on('change', function() {
                toggleFields();
            });
        });
    </script>
@stop
