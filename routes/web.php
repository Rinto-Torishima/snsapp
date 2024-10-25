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

// use Illuminate\Routing\Route;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/topics/search', 'TopicsController@search')->name('topics.search');
Route::get(
    '/',
    'TopicsController@welcome'
);
Route::resource('/topics', 'TopicsController');
// コメント消去
Route::delete('/comment/{id}', 'CommentController@destroy')->name('cmt.destroy');
// コメント編集
Route::get('/comment/{id}/edit', 'CommentController@edit')->name('cnt.edit');
Route::put('/comment/{id}', 'CommentController@update')->name('cnt.update');
// ログイン判定
Route::post('/topics', 'TopicsController@store')->name('topics.store')->middleware('auth');
Route::post('/topics/post', 'CommentController@store')->name('cmt.store')->middleware('auth');
// 検索機能
Route::post('/like', 'CommentController@like');
Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home');
