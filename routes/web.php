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

//use Illuminate\Routing\Route;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/topics', 'TopicsController');
// コメント消去
Route::delete('/comment/{id}', 'CommentController@destroy')->name('cmt.destroy');
// コメント編集
Route::get('/comment/{id}/edit', 'CommentController@edit')->name('cnt.edit');
Route::put('/comment/{id}', 'CommentController@update')->name('cnt.update');
// ログイン判定
Route::post('/topics', 'TopicsController@store')->name('topics.store')->middleware('auth');
Route::post('/topics/post', 'CommentController@store')->name('cmt.store')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
