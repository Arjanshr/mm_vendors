@extends('adminlte::page')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Add Coupon')

@section('content_header')
    <h1>{{ isset($coupon) ? 'Edit Coupon' : 'Create New Coupon' }}</h1>
@stop

@section('content')
    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($coupon) ? 'Edit Coupon' : 'Create New Coupon' }}</h3>
                            </div>
                            @livewire('coupon-form', ['coupon' => $coupon ?? null])
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
