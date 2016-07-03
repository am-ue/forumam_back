<?php

Route::group(['prefix' => config('admin.path'), 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('home');
});