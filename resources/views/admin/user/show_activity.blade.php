@extends('adminlte::page')

@section('title', 'Activity')

@section('content_header')
    <h1>Activity</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-clock"></i>
                                Activity Timestamp
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $activity->created_at . '(' . $activity->created_at->diffForHumans() . ')' }}
                            </blockquote>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar"></i>
                                Event
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                {{ ucfirst($activity->event) }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list"></i>
                                Activity Subject Type
                            </h3>
                        </div>

                        <div class="card-body">
                            <blockquote>
                                {{ $activity->subject_type }}
                            </blockquote>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Activity Subject Name
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                {{ $activity->subject->name ?? 'NA' }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                Activity Causer Name
                            </h3>
                        </div>

                        <div class="card-body clearfix">
                            <blockquote>
                                {{ $activity->causer->name }}
                            </blockquote>
                        </div>

                    </div>

                </div>
                @if (isset($activity->Changes['attributes']))
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-money-bill"></i>
                                    Current values
                                </h3>
                            </div>
                            <div class="card-body">
                                <blockquote>
                                    @foreach ($activity->Changes['attributes'] as $index => $value)
                                        {{ $index }} &#8594 {{ $value }}<br />
                                    @endforeach
                                </blockquote>
                            </div>

                        </div>

                    </div>
                @endif
                @if (isset($activity->Changes['old']))
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-money-bill"></i>
                                    Previous values
                                </h3>
                            </div>

                            <div class="card-body">
                                <blockquote>
                                    @foreach ($activity->Changes['old'] as $index => $value)
                                        {{ $index }} &#8594 {{ $value }}<br />
                                    @endforeach
                                </blockquote>
                            </div>

                        </div>

                    </div>
                @endif

            </div>

        </div>

    </section>
@stop

@section('css')
@stop

@section('js')

@stop
