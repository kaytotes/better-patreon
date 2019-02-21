<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Base Pages */
Route::get('', 'Base\Pages\Home')->name('home');

/* Login Page */
Route::get('login', 'Auth\LoginController')->name('login');

/* Registration */
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

/* Password Reset */
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
