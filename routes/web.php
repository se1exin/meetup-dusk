<?php

Route::get('/', 'LoginController@index');
Route::get('/dashboard', 'LoginController@dashboard');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');

Route::get('/register', 'RegisterController@register');
Route::post('/register', 'RegisterController@register');
Route::get('/payment', 'RegisterController@payment');
Route::post('/payment', 'RegisterController@payment');
Route::get('/payment-success', 'RegisterController@paymentSuccess');
Route::post('/payment-success', 'RegisterController@paymentSuccess');
Route::get('/token', 'RegisterController@csrfToken');