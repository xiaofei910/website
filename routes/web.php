<?php

use Illuminate\Support\Facades\Route;

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
Route::prefix('admin')->group(function(){
   Route::get('/','IndexController@index');
    Route::any('/nav','IndexController@nav');
    Route::any('/addnav','IndexController@addnav');
    Route::any('/shownav','IndexController@shownav');
    Route::any('/delnav','IndexController@delnav');
    Route::any('/updnav/{id}','IndexController@updnav');
    Route::any('/editnav/{id}','IndexController@editnav');
    Route::any('/editsorts','IndexController@editsorts');
    Route::any('/edithidden','IndexController@edithidden');
});