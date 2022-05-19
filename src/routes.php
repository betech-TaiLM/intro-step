<?php

Route::group(['namespace' => "Bisync\IntroStep\Controllers"], function () {

    Route::group(['namespace' => 'Api', 'prefix' => 'intro-step-admin/api', 'as' => 'intro-step-admin.api.', 'middleware' => config('intro-step.api_middleware')], function () {
        Route::resource('steps', 'StepsController');
        Route::resource('user', 'UserController')->only('store');
    });

    Route::group(['prefix' => 'intro-step-admin', 'as' => 'intro-step-admin.', 'middleware' => config('intro-step.web_middleware')], function () {
        Route::get('/', 'IntroStepController@index');

        Route::resource('api', "Api\IndexController")->middleware(config('intro-step.api_middleware'));
    });

    Route::resource('intro-step-admin', 'IntroStepController')->middleware(config('intro-step.web_middleware'));
});
