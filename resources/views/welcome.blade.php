@extends('layouts.default')
@section('content')
    @if(Auth::check())
        <div>
            User logged
        </div>
        <div>
            Hi {{\Illuminate\Support\Facades\Auth::getUser()->name}}!
        </div>
    @else
        <div>
            Not logged
        </div>
    @endif
@stop
