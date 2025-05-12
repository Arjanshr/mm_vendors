@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
    <h1>Orders</h1>
@stop

@section('content')


    <div class="card-body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($order) ? 'Edit order' : 'Create New Order' }}</h3>
                            </div>
                            <form method="POST"
                                action="{{ isset($order) ? route('order.update', $order->id) : route('order.insert') }}">
                                @csrf
                                @if (isset($order))
                                    @method('patch')
                                @endif
                                @if (isset($order))
                                    @livewire('order-form', ['order' => $order])
                                @else
                                    @livewire('order-form')
                                @endif
                                <div class="form-group col-sm-12">
                                    <input type="submit" value="{{ isset($order) ? 'Edit' : 'Create' }}"
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
    <style>
        .select2-selection__rendered {
            line-height: 40px !important;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
@stop

@section('js')
@stop
