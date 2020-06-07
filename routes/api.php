<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Set-Cookie, X-Auth-Token, X-Requested-With, Accept, Origin, Authorization, x-xsrf-token, X-File-Name, Cache-Control');


Route::post('auth/login', 'API\AuthController@login');

Route::group(['middleware' => 'apiJwt', 'prefix' => ''], function ($router) {
    Route::post('auth/logout', 'API\AuthController@logout');
    Route::post('auth/refresh', 'API\AuthController@refresh');
    Route::post('auth/me', 'API\AuthController@me');

    Route::get('user/search', 'API\UserController@search')->name('user.search');
    Route::post('user/update', 'API\UserController@update')->name('user.update');
    Route::get('user/birthdays/{month}', 'API\UserController@birthdays')->name('user.birthdays')->where('id', '[0-9]+');

    Route::apiResource('user', 'API\UserController')->names([
        'create' => 'user.create',
        'show' => 'user.show',
        'index' => 'user.index',
        'destroy' => 'user.destroy',
    ])->only([
        'index', 'store', 'show'
    ]);

    Route::get('department', 'API\DepartmentController@index')->name('department.index');
    Route::get('work-schedule', 'API\WorkScheduleController@index')->name('workSchedule.index');

    Route::get('status', 'API\StatusController@index')->name('status.index');
    Route::get('status/{id}', 'API\StatusController@show')->name('status.show')->where('id', '[0-9]+');
    Route::get('status/users', 'API\StatusController@statusWithUsers')->name('status.statusWithUsers');

    Route::get('user-status/user/{id}/{date}', 'API\UserStatusController@userStatusByFrom')->name('userStatus.userStatusByFrom');
    Route::post('user-status/update', 'API\UserStatusController@update')->name('userStatus.update');
    Route::apiResource('user-status', 'API\UserStatusController')->names([
        'create' => 'userStatus.create',
        'show' => 'userStatus.show',
        'index' => 'userStatus.index'
    ])->only([
        'index', 'store', 'show'
    ]);
});
