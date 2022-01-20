<?php

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'AppController@index');

Route::get('/numberchain/solution', 'App\NumberchainController@solution');
Route::get('/numberchain/data', 'App\NumberchainController@data');
Route::post('/numberchain/test-problem', 'App\NumberchainController@testProblem')->name('test-problem');
Route::post('/numberchain/test-numberchain', 'App\NumberchainController@testNumberchain')->name('test-numberchain');

Route::get('/zipcodes/solution', 'App\ZipcodesController@solution');
Route::get('/zipcodes/docs', 'App\ZipcodesController@docs');
Route::post('/zipcodes/distance', 'App\ZipcodesController@distance')->name('zipcode-distance');
Route::post('/zipcodes/search', 'App\ZipcodesController@search')->name('zipcode-search');
