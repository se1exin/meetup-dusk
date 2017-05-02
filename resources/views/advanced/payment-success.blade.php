@extends('master')

@section('html_title', 'Payment Success')
@section('register_nav_stage_2_class', 'active')

@section('body_class', 'bg-input-color form-page')

@section('extra_css')
<link href="/css/advanced.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
@include('advanced/partials/register-nav')

<section id="payment-success" class="auth-page container no-flex pad-left pad-right bg-grey">
    <div class="symbol-container">
        <svg id="fe23f8f6-4194-4c24-82b9-d63b3ce8db2c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1550 1188"><defs><style>.bc771918-6a4e-455f-b901-44029f18af16{fill:#FFFFFF;}</style></defs><title>check</title><path class="bc771918-6a4e-455f-b901-44029f18af16" d="M1550,232q0,40-28,68L798,1024,662,1160q-28,28-68,28t-68-28L390,1024,28,662Q0,634,0,594t28-68L164,390q28-28,68-28t68,28L594,685,1250,28q28-28,68-28t68,28l136,136Q1550,192,1550,232Z"/></svg>
    </div>
    <div class="text-container">
        <h2 class="price">$9.99</h2>
        <p class="congratulations">Congratulations!<br>Your subscription has been activated.<p>
        <p class="confirmation">A confirmation email has been sent to {{$user->email}}</p>
        {{--
        Button hidden until receipts are in full effect
        <a href="/payment-success"><button class="form-submit txt-white bg-blue btn-circle" value="receipt">View Receipt</button></a>
        --}}
        <p class="terms-container"><a href="/terms" class="txt-blue">Terms &amp; Conditions</a> and <a href="/privacy" class="txt-blue">Privacy Policy</a></p>
    </div>
</section>
@endsection
