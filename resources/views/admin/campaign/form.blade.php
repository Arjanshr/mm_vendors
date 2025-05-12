@extends('adminlte::page')

@section('title', 'Campaigns')

@section('content_header')
    <h1>Campaigns</h1>
@stop

@section('content')
    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Removed Sortable Campaign List -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($campaign) ? 'Edit Campaign' : 'Create New Campaign' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($campaign) ? route('campaigns.update', $campaign->id) : route('campaigns.insert') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if (isset($campaign))
                                    @method('patch')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="form-group col-md-12">
                                            <label for="name">Name*</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Name"
                                                value="{{ isset($campaign) ? $campaign->name : old('name') }}" required>
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Start Date -->
                                        <div class="form-group col-md-6">
                                            <label for="start_date">Start Date*</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ isset($campaign) ? $campaign->start_date : old('start_date') }}"
                                                required>
                                            @error('start_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- End Date -->
                                        <div class="form-group col-md-6">
                                            <label for="end_date">End Date*</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                value="{{ isset($campaign) ? $campaign->end_date : old('end_date') }}" required>
                                            @error('end_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Status -->
                                        <div class="form-group col-md-6">
                                            <label for="status">Status*</label>
                                            <select id="status" name="status" class="form-control" required>
                                                <option value="">Select a status</option>
                                                <option value="active"
                                                    {{ (isset($campaign) && $campaign->status == 'active') || old('status') == 'active' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="inactive"
                                                    {{ (isset($campaign) && $campaign->status == 'inactive') || old('status') == 'inactive' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Color Theme -->
                                        <div class="form-group col-md-6">
                                            <label for="color_theme">Color Theme</label>
                                            <input type="color" class="form-control" id="color_theme" name="color_theme"
                                                value="{{ isset($campaign) ? $campaign->color_theme : old('color_theme', '#ffffff') }}">
                                            @error('color_theme')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Background Image -->
                                        <div class="form-group col-md-6">
                                            <label for="background_image">Background Image</label>
                                            @if(isset($campaign) && $campaign->background_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $campaign->background_image) }}" alt="Background Image" width="150">
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="remove_background_image" name="remove_background_image" value="1">
                                                    <label class="form-check-label" for="remove_background_image">Remove current image</label>
                                                </div>
                                            @else
                                                <input type="file" class="form-control" id="background_image" name="background_image">
                                                @error('background_image')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>

                                        <!-- Campaign Banner -->
                                        <div class="form-group col-md-6">
                                            <label for="campaign_banner">Campaign Banner</label>
                                            @if(isset($campaign) && $campaign->campaign_banner)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $campaign->campaign_banner) }}" alt="Campaign Banner" width="150">
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="remove_campaign_banner" name="remove_campaign_banner" value="1">
                                                    <label class="form-check-label" for="remove_campaign_banner">Remove current banner</label>
                                                </div>
                                            @else
                                                <input type="file" class="form-control" id="campaign_banner" name="campaign_banner">
                                                @error('campaign_banner')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Submit Button -->
                                        <div class="form-group col-md-12 text-center">
                                            <input id="submit" type="submit"
                                                value="{{ isset($campaign) ? 'Edit' : 'Create' }}" class="btn btn-primary" />
                                        </div>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#sortable-campaigns").sortable({
                update: function(event, ui) {
                    let order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.ajax({
                        url: "{{ route('campaigns.updateOrder') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function(response) {
                            alert('Order updated successfully!');
                        },
                        error: function() {
                            alert('Failed to update order.');
                        }
                    });
                }
            });
        });
    </script>
@stop
