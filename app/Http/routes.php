<?php
Route::singularResourceParameters();

Route::group(['prefix' => config('admin.path'), 'namespace' => 'Admin'], function () {


    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('admin.home');

        Route::group(['middleware' => 'canAccess'], function () {

            Route::get('users/datatable', 'UserController@datatable');
            Route::resource('users', 'UserController');

            Route::get('companies/datatable', 'CompanyController@datatable');
            Route::resource('companies', 'CompanyController');

            Route::get('categories/datatable', 'CategoryController@datatable');
            Route::resource('categories', 'CategoryController');

            Route::get('options/datatable', 'OptionController@datatable');
            Route::resource('options', 'OptionController');
        });
    });

    Route::group(['namespace' => 'Auth', 'as' => 'admin.'], function () {
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