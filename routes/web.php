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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::resource('/g', 'Goods\GoodsController');
//登录
Route::get('/login','Login\LoginController@login');
//执行登录
Route::post('/login','Login\LoginController@logindo');

Route::post('/loginCheck','Login\LoginController@loginCheck');

//图片网站
Route::get('/img','Img\ImgController@index');