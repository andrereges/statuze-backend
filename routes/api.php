<?php

use Illuminate\Support\Facades\Route;

Route::post('auth/login', 'API\AuthController@login');

Route::apiResource('user', 'API\UserController')->names([
    'create' => 'user.create',
    'show' => 'user.show',
    'index' => 'user.index',
    'destroy' => 'user.destroy',
])->only([
    'index', 'store', 'show'
]);

Route::group(['middleware' => 'apiJwt', 'prefix' => ''], function ($router) {
    Route::post('auth/logout', 'API\AuthController@logout');
    Route::post('auth/refresh', 'API\AuthController@refresh');
    Route::post('auth/me', 'API\AuthController@me');

    Route::get('user/search', 'API\UserController@search')->name('user.search');
    Route::post('user/update', 'API\UserController@update')->name('user.update');

    // Route::apiResource('user', 'API\UserController')->names([
    //     'create' => 'user.create',
    //     'show' => 'user.show',
    //     'index' => 'user.index',
    //     'destroy' => 'user.destroy',
    // ])->only([
    //     'index', 'store', 'show'
    // ]);

    Route::get('status', 'API\StatusController@index')->name('status.index');

    Route::post('user-status/update', 'API\UserStatusController@update')->name('userStatus.update');
    Route::apiResource('user-status', 'API\UserStatusController')->names([
        'create' => 'userStatus.create',
        'show' => 'userStatus.show',
        'index' => 'userStatus.index'
    ])->only([
        'index', 'store', 'show'
    ]);
});
