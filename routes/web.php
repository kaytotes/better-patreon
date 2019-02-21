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
Route::get('', 'Web\Base\Pages\Home')->name('home');

/* Login Page */
Route::get('login', 'Web\Auth\LoginController')->name('login');

/* Registration */
Route::get('register', 'Web\Auth\RegisterController')->name('register');

/* Password Reset */
Route::get('password/reset', 'Web\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Web\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Web\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Web\Auth\ResetPasswordController@reset')->name('password.update');

/* Email Verification */
Route::get('email/verify', 'Web\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Web\Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Web\Auth\VerificationController@resend')->name('verification.resend');
