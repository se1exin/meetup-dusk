<?php

Route::get('/', 'LoginController@index');
Route::get('/dashboard', 'LoginController@dashboard');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');

