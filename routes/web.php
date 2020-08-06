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
})->name('home');

Auth::routes();

Route::get('/login/insta','Auth\LoginController@redirectToInsta');
Route::get('/login/insta/callback', 'Auth\LoginController@handleInstaCallback');

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
