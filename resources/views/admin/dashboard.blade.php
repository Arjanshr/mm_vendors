@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">

    </div>
@stop


@section('right-sidebar')
    <div class="p-3">
        <h5>User Activities</h5>
        <ul class="list-group">
            @forelse ($activities as $activity)
                <li class="list-group-item">
                    {{ $activity->causer ? $activity->causer->name : 'Someone' }} 
                    {{ $activity->description }} 
                    {{ $activity->subject&&$activity->subject->name&&$activity->subject->name!='' ? $activity->subject->name : 'a '.last(explode('\\', $activity->subject_type)) }} 
                    <small class="text-muted">({{ $activity->created_at->diffForHumans() }})</small>
                </li>
            @empty
                <li class="list-group-item text-center">No recent activities.</li>
            @endforelse
        </ul>
    </div>
@endsection
