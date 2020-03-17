<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::get('/redis/detail', 'RedisController@detail');
Route::get('/redis/index', 'RedisController@index');
Route::get('/redis/list', 'RedisController@list');
Route::get('/redis/list1', 'RedisController@list1');
Route::get('/redis/redistyep', 'RedisController@redistyep');


Route::get('/redis/AddUserToRedis', 'MiaoShaController@AddUserToRedis');
Route::get('/redis/AddGoodToRedis/{id}', 'MiaoShaController@AddGoodToRedis');
Route::get('/redis/Kill/{id}', 'MiaoShaController@Kill');




Route::get('/redis/Kill2/{id}', 'MiaoShaController@Kill2');
Route::get('/redis/AddGoodToRedis2/{id}', 'MiaoShaController@AddGoodToRedis2');




Route::get('/redis/getGood', 'MiaoShaController@getGood');


Route::get('/test/index', 'TestController@index');

//ab -n 1000 -c 500 http://www.test.com/redis/Kill/1

//ab -n 1000 -c 500 http://www.test.com/redis/Kill2/1