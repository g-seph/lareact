<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LaReact</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite('resources/css/app.css')
    <!-- Styles -->
    @yield('styles')
</head>
<body class="antialiased">
<header id="header">
    @include('partials.header')
</header>

<div class="flex justify-center">
    <div id="main" class="mx-4 my-2">
        @if($errors)
            <ul class="my-8">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
