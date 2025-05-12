@extends('adminlte::page')
@section('title', 'Campaign Products')
@section('content')


    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Zero config.table start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-list"></i> List Campaign Products</h5>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Manage Products</label>
                                    <form method="POST"
                                        action="{{ route('campaigns.products.action', $campaign->id) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select name="products[]" id="products" class="form-control" multiple>
                                                    <option value="">--select--</option>
                                                    @if (isset($products))
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                @if (isset($product) &&
                                                                        $campaign->products()->where('product_id', $product->id)->exists()) {{ 'selected' }} @endif>
                                                                {{ $product->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" value="Update Products" class="btn btn-primary" />
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table class="table general-datatable table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Default Price</th>
                                                    <th>Campaign Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($campaign))
                                                    @foreach ($campaign->products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $product->price }}</td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-10">
                                                                        <input type="number"
                                                                            class="form-control campaign-price-{{ $product->id }}"
                                                                            value="{{ $campaign->products()->where('product_id',$product->id)->first()->pivot->campaign_price }}">
                                                                    </div>
                                                                    <div class="col-2"
                                                                        style="padding-top:5px; padding-bottom:5px">
                                                                        <button
                                                                            class="btn btn-sm btn-primary update-discount"
                                                                            data-product-id="{{ $product->id }}">Update</button>
                                                                    </div>
                                                                    <div class="col-12 success-message"
                                                                        id="success-message-{{ $product->id }}"></div>
                                                                </div>

                                                            </td>

                                                            <td>
                                                                <a href="{{ route('campaigns.products.delete', ['campaign' => $campaign->id, 'product' => $product->id]) }}"
                                                                    title="Remove Product"
                                                                    class="btn btn-danger btn-mini confirm_btn"><i
                                                                        class="icofont icofont-ui-delete p-r-3"></i>Remove
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Zero config.table end -->


                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->

    </div>

@endsection
@section('css')
    <style>
        .select2-selection__choice {            
            color: #000 !important;
            font-size: larger !important;

        }

        .select2-selection__choice__remove {
            color: rgb(201, 14, 14) !important;
            font-size: larger !important;

        }

        td {
            white-space: normal !important;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#products').select2();
        });

        $(".update-discount").click(function() {
            var product_id = $(this).data('product-id');
            var campaign_price = $(".campaign-price-" + product_id).val();
            $.ajax({
                url: "/admin/update-discount",
                method: "post",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'product_id': product_id,
                    'campaign_id': {{$campaign->id}},
                    'campaign_price': campaign_price
                },
                success: function(data) {
                    $('.success-message').empty();
                    $('#success-message-' + product_id).addClass("bg-success text-center");
                    $('#success-message-' + product_id).fadeIn().html(data['message']);
                },
                error: function(err) {
                    if (err.status == 422) { // when status code is 422, it's a validation issue
                        $('.success-message').empty();
                        $('#success-message-' + product_id).addClass("bg-danger text-center");
                        $('#success-message-' + product_id).fadeIn().html(err.responseJSON.message);

                        // you can loop through the errors object and show it to the user
                        // console.warn(err.responseJSON.errors);
                        // display errors on each form field
                        // $.each(err.responseJSON.errors, function(i, error) {
                        //     var el = $(document).find('[name="' + i + '"]');
                        //     el.after($('<span style="color: red;">' + error[0] + '</span>'));
                        // });
                    }
                }
            });
        });
    </script>
@endsection
