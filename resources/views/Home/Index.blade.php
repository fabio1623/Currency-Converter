@extends('welcome')

@section('content')

<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endif
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Digidip Test
        </div>

        <div class="links">
            <a href="{{ action('CurrencyController@index') }}">Currency Rate (Euro)</a>
            <a href="{{ action('CurrencyController@convertPage') }}">Euro Converter</a>
            <a href="{{ action('CurrencyController@activeUsers') }}">Amount per active user</a>
            <a href="{{ action('CurrencyController@earnings') }}">Earnings - 2014</a>
            <!-- <a href="https://laravel-news.com">News</a>
            <a href="https://forge.laravel.com">Forge</a>
            <a href="https://github.com/laravel/laravel">GitHub</a> -->
        </div>
    </div>
</div>

@endsection
