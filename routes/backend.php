<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {

    Route::get( '/', [ 'as' => 'admin', 'uses' => 'DashboardController@index' ] );

    Route::group(['prefix' => 'products', 'namespace' => 'Product'], function () {
        Route::post('/products/add', ['as' => 'admin.products.product.add', 'uses' => 'ProductController@productAdd']);
        Route::post('/products/calculate', ['as' => 'admin.products.edit', 'uses' => 'ProductController@calculateSum']);
        Route::get( '/', [ 'as' => 'admin.products', 'uses' => 'ProductController@index' ] );
        Route::get('{id}/edit', ['as' => 'admin.products.edit', 'uses' => 'ProductController@edit']);
        Route::post('{id}/', ['as' => 'admin.products.update','uses' => 'ProductController@update']);
    });

    Route::group(['prefix' => 'orders', 'namespace' => 'Order'], function () {
        Route::post('/products/add', ['as' => 'admin.orders.product.add', 'uses' => 'OrderController@productAdd']);
        Route::post('/products/calculate', ['as' => 'admin.orders.edit', 'uses' => 'OrderController@calculateSum']);
        Route::get( '/', [ 'as' => 'admin.orders', 'uses' => 'OrderController@index' ] );
        Route::get('{id}/edit', ['as' => 'admin.orders.edit', 'uses' => 'OrderController@edit']);
        Route::post('{id}/', ['as' => 'admin.orders.update','uses' => 'OrderController@update']);
    });

    Route::group(['prefix' => 'reservations', 'namespace' => 'Reservation'], function () {
        Route::get( '/refresh', [ 'as' => 'admin.reservations', 'uses' => 'ReservationController@refresh' ] );
        Route::get( '/', [ 'as' => 'admin.reservations', 'uses' => 'ReservationController@index' ] );
        Route::get('{id}/view', ['as' => 'admin.reservations.view', 'uses' => 'ReservationController@view']);
        Route::get('{id}/edit', ['as' => 'admin.reservations.edit', 'uses' => 'ReservationController@edit']);
        Route::post('{id}/', ['as' => 'admin.reservations.update','uses' => 'ReservationController@update']);
    });
});
