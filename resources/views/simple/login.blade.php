@extends('master')

@section('title', 'Login')

@section('extra_css')
    <link href="/css/simple.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h2 class="title txt-center">Login</h2>
    <form id="login-form" class="form" method="POST" action="/login">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <input type="submit" class="submit" value="LOGIN">
        </div>

        {!! csrf_field() !!}
    </form>
    <p class="login-status">{!! session('login_status')  !!}</p>

@endsection