<?php

Route::group(['namespace' => 'FB', 'prefix' => 'fb'],function () {
    Route::get('webhook', 'WebhookController@verify');
    Route::post('webhook', 'WebhookController@handle');
});