@extends('master')

@section('title', 'Dashboard')

@section('extra_css')
    <link href="/css/simple.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h2 class="title txt-center">You are logged in!!</h2>
    <p class="txt-center"><a class="logout" href="/logout">Logout</a></p>
@endsection