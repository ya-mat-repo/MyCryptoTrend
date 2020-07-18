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
    return view('index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@home')->name('home');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/list', 'AccountListController@list')->name('list');
    Route::post('/follow_account', 'AccountListController@followAccount')->name('follow_account');
    Route::post('/unfollow_account', 'AccountListController@unfollowAccount')->name('unfollow_account');
    Route::post('/auto_follow', 'AccountListController@autoFollow')->name('auto_follow');
    Route::get('/twitter_auth', 'TwitterAuthController@twitterAuth')->name('twitter_auth');
    Route::get('/get_request_token', 'TwitterAuthController@getRequestToken')->name('get_request_token');
    Route::get('/get_access_token', 'TwitterAuthController@getAccessToken')->name('get_access_token');
    Route::get('/news', 'NewsController@news')->name('news');
    Route::get('/registration_tw', 'TwitterAuthController@registrationTwitterAccount')->name('registration_tw');
    Route::post('/registration_tw', 'TwitterAuthController@registerTwitter')->name('twitter_register');
});
