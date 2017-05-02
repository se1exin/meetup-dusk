@extends('master')

@section('title', 'Register')

@section('body_class', 'form-page')
@section('register_nav_stage_1_class', 'active')

@section('extra_css')
<link href="/css/advanced.css" rel="stylesheet" type="text/css">
@endsection
@section('extra_js')
<script src="/js/register.js"></script>
@endsection

@section('content')
<section id="banner" class="payment-banner">
    <div class="container no-flex pad-left pad-right">
        <h2 class="title txt-shark-a">Register Today</h2>
        <p class="subtitle">
            Registering only takes a minute. Once you are registered you can come back at any time to update details.<br><br>Just fill in the few details needed below to get the ball rolling.
        </p>
    </div>
</section>
@include('advanced/partials/register-nav')
<section id="register" class="auth-page container no-flex pad-left pad-right">
    <form class="auth-form" id="register-form" action="/register" method="POST">
        <section class="container no-flex">
            <p class="error-message {{ (!$error_bag['success']) ? 'show' : '' }}">
                @if(!$error_bag['success'])
                {!! $error_bag['error'] !!}
                @endif
            </p>
        </section>

        <section class="container">
            <h2 class="title">Administrator <br>Contact Details</h2>

            <div class="input-wrap text first-name left {{ ($error_bag['first_name_error']) ? 'error' : '' }}">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" class="form-text required" placeholder="Name" value="{{ $input_bag['first_name'] }}" />
                <span class="helper">{!! $error_bag['first_name_error'] !!}</span>
            </div>
            <div class="input-wrap text last-name right {{ ($error_bag['last_name_error']) ? 'error' : '' }}">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last_name" class="form-text required" placeholder="Name" value="{{ $input_bag['last_name'] }}" />
                <span class="helper">{!! $error_bag['last_name_error'] !!}</span>
            </div>
            <div class="input-wrap text address-street {{ ($error_bag['address_street']) ? 'error' : '' }}">
                <label for="address-street">Address</label>
                <input type="text" id="address-street" name="address_street" class="form-text required" placeholder="123 Location Street" value="{{ $input_bag['address_street'] }}" />
                <span class="helper">{!! $error_bag['address_street'] !!}</span>
            </div>
            <div class="input-wrap text address-city left {{ ($error_bag['address_city_error']) ? 'error' : '' }}">
                <label for="address-city">City</label>
                <input type="text" id="address-city" name="address_city" class="form-text required" placeholder="Randwick" value="{{ $input_bag['address_city'] }}" />
                <span class="helper">{!! $error_bag['address_city_error'] !!}</span>
            </div>
            <div class="input-wrap text address-postcode right {{ ($error_bag['address_postcode_error']) ? 'error' : '' }}">
                <label for="address-postcode">Postcode</label>
                <input type="text" id="address-postcode" name="address_postcode" class="form-text required" placeholder="2031" value="{{ $input_bag['address_postcode'] }}" />
                <span class="helper">{!! $error_bag['address_postcode_error'] !!}</span>
            </div>
            <div class="input-wrap text address-state left {{ ($error_bag['address_state_error']) ? 'error' : '' }}">
                <label for="address-state">State</label>
                <input type="text" id="address-state" name="address_state" class="form-text required" placeholder="New South Wales" value="{{ $input_bag['address_state'] }}" />
                <span class="helper">{!! $error_bag['address_state_error'] !!}</span>
            </div>
            <div class="input-wrap text email {{ ($error_bag['email_error']) ? 'error' : '' }}">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-text required" placeholder="someone@somewhere.com" value="{{ $input_bag['email'] }}" />
                <span class="helper">{!! $error_bag['email_error'] !!}</span>
            </div>
            <div class="input-wrap text phone {{ ($error_bag['phone_error']) ? 'error' : '' }}">
                <label for="phone">Contact Phone</label>
                <input type="text" id="phone" name="phone" class="form-text required" placeholder="02 4444 4444" value="{{ $input_bag['phone'] }}" />
                <span class="helper">{!! $error_bag['phone_error'] !!}</span>
            </div>
        </section>
        <section class="container">
            <h2 class="title">Security</h2>

            <div class="input-wrap text password {{ ($error_bag['password_error']) ? 'error' : '' }}">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-text required" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" value="{{ $input_bag['password'] }}" />
                <span class="helper">{!! $error_bag['password_error'] !!}</span>
                <span class="input-helper">Password must be minimum 6 characters</span>
            </div>
            <div class="input-wrap text password {{ ($error_bag['confirm_password_error']) ? 'error' : '' }}">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" class="form-text required" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" />
                <span class="helper">{!! $error_bag['confirm_password_error'] !!}</span>
            </div>
        </section>
        <section class="container no-flex form-footer">
            <div class="input-wrap submit">
                <button type="submit" class="form-submit txt-white bg-blue btn-circle" name="submit">
                    <span class="loading"></span>
                    <span class="text">Register</span>
                </button>
            </div>

            <p>By registering you confirm that you agree with our <br><a href="/terms" class="txt-blue">Terms &amp; Conditions</a> and <a href="/privacy" class="txt-blue">Privacy Policy</a></p>
        </section>
    </form>
</section>
@endsection
