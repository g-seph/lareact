@extends('layouts.default')
@section('content')
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp
    <div>
        User details page
    </div>
    <div>
        User: {{$user->name}}, {{$user->email}}
</div>
@stop
