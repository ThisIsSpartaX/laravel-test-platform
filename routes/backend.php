<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {

    Route::get( '/', [ 'as' => 'admin', 'uses' => 'DashboardController@index' ] );

    Route::group(['prefix' => 'orders', 'namespace' => 'Order'], function () {
        Route::post('/products/add', ['as' => 'admin.orders.product.add', 'uses' => 'OrderController@productAdd']);
        Route::post('/products/calculate', ['as' => 'admin.orders.edit', 'uses' => 'OrderController@calculateSum']);
        Route::get( '/', [ 'as' => 'admin.orders', 'uses' => 'OrderController@index' ] );
        Route::get('{id}/edit', ['as' => 'admin.orders.edit', 'uses' => 'OrderController@edit']);
        Route::post('{id}/', ['as' => 'admin.orders.update','uses' => 'OrderController@update']);
    });
});
