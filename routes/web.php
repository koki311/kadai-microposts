<?php


Route::get('/', 'MicropostsController@index');

// ユーザ登録
///signupにアクセスするとResisterControllerのshowRegistrationFormメソッドで処理
//たどっていくと、resource/views/auth/register.blade.phpを表示する
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
///signupにアクセスするとResisterControllerのregisterメソッドで新規作成処理
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

//認証付きルーティング(https://laraweb.net/practice/1854/)
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users','UsersController',['only'=>['index','show']]);
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});