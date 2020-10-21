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

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/chef/my-dishes', function () {
    return view('account/chef/dishes');
})->middleware(['is_chef']);

Auth::routes(['verify' => true]);

Route::get('/login/insta','Auth\LoginController@redirectToInsta');
Route::get('/login/insta/callback', 'Auth\LoginController@handleInstaCallback');

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');

Route::get('api/me','Chefs@me')->middleware(['is_chef']);
Route::put('api/save-me','Chefs@saveProfile')->middleware(['is_chef']);
Route::get('api/dish','Chefs@dish')->middleware(['is_chef']);
Route::put('api/dish/{id}','Chefs@saveDish')->middleware(['is_chef']);
Route::post('api/place-order','Chefs@placeOrder');

Route::get('api/random-dish','Chefs@randomDish');
Route::get('api/chefs','Chefs@index');
Route::get('chef-image/{image}','Chefs@image');
Route::get('dish-image/{image}','Chefs@dishImage');
