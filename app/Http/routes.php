<?php

Route::group(['prefix' => config('admin.path'), 'as' => 'admin.', 'namespace' => 'Admin'], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('home');

    });

    Route::group(['namespace' => 'Auth'], function () {
        // Authentication Routes...
        Route::get('login', 'AuthController@showLoginForm')->name('login');
        Route::post('login', 'AuthController@login')->name('postLogin');
        Route::get('logout', 'AuthController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'AuthController@showRegistrationForm')->name('register');
        Route::post('register', 'AuthController@register')->name('postRegister');

        // Password Reset Routes...
        Route::get('password/reset/{token?}', 'PasswordController@showResetForm')->name('passwordReset');
        Route::post('password/email', 'PasswordController@sendResetLinkEmail')->name('postPasswordEmail');
        Route::post('password/reset', 'PasswordController@reset')->name('postPasswordReset');
    });
});