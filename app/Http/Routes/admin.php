<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('home');

    Route::group(['middleware' => 'canAccess'], function () {

        Route::get('users/datatable', 'UserController@datatable');
        Route::resource('users', 'UserController');

        Route::get('companies/datatable', 'CompanyController@datatable');
        Route::resource('companies', 'CompanyController');

        Route::get('categories/datatable', 'CategoryController@datatable');
        Route::resource('categories', 'CategoryController');

        Route::get('options/datatable', 'OptionController@datatable');
        Route::post('options/reordering', 'OptionController@reorder');
        Route::resource('options', 'OptionController');

        Route::get('relations/datatable', 'OptionRelationController@datatable');
        Route::resource('relations', 'OptionRelationController');

        Route::get('posts/datatable', 'PostController@datatable');
        Route::resource('posts', 'PostController');

        Route::get('companies/{company}/orders', 'OrderController@index')->name('orders.index');
        Route::get('companies/{company}/orders/edit', 'OrderController@edit')->name('orders.edit');
        Route::post('companies/{company}/orders', 'OrderController@store');
        Route::get('companies/{company}/orders/datatable', 'OrderController@datatable');

    });
});

Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@postLogin')->name('postLogin');
    Route::get('logout', 'AuthController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'AuthController@showRegistrationForm')->name('register');
    Route::post('register', 'AuthController@register')->name('postRegister');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'PasswordController@showResetForm')->name('passwordReset');
    Route::post('password/email', 'PasswordController@sendResetLinkEmail')->name('postPasswordEmail');
    Route::post('password/reset', 'PasswordController@reset')->name('postPasswordReset');
});
