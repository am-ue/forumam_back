<?php

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        if (auth()->user()->isAdmin()) {
            return view('dashboard');
        } else {
            session()->reflash();
            return redirect()->action('Admin\OrderController@index', auth()->user()->company_id);
        }
    })->name('home');

    Route::get('log_as/{user?}', 'UserController@logAs');

    Route::group(['middleware' => 'canAccess'], function () {

        Route::get('/download/companies', 'DownloadController@companies');
        Route::get('/download/products', 'DownloadController@products');
        Route::get('/download/badges', 'DownloadController@badges');
        Route::get('/download/results', 'DownloadController@results');

        Route::get('users/datatable', 'UserController@datatable');
        Route::resource('users', 'UserController');

        Route::get('companies/datatable', 'CompanyController@datatable');
        Route::resource('companies', 'CompanyController');

        Route::get('categories/datatable', 'CategoryController@datatable');
        Route::resource('categories', 'CategoryController');

        Route::get('config-variables/datatable', 'ConfigVariableController@datatable');
        Route::resource('config-variables', 'ConfigVariableController');

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

        Route::get('badges', 'BadgeController@index')->name('badges.index');
        Route::get('companies/{company}/badges/edit', 'BadgeController@edit')->name('badges.edit');
        Route::post('companies/{company}/badges', 'BadgeController@store');
        Route::get('companies/{company}/badges/datatable', 'BadgeController@datatable');
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
