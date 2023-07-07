<div class="px-16 shadow-md">
    @if(Auth::check())
        @php
            $user = \Illuminate\Support\Facades\Auth::getUser();
        @endphp
        <form action="{{route('user.logout.action')}}" method="post">
            <a href="/">Home</a>
            <a href="{{route('user.details.page')}}">{{$user->email}}</a>
            @csrf
            <button style="padding: 0!important" type="submit">Logout</button>
        </form>
    @else
        <a href="/">Home</a>
        <a href="{{route('login.page')}}">Login</a>
        <a href="{{route('register.page')}}">Register</a>
    @endif
</div>
