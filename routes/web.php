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
    Route::group(['prefix' => 'users/{id}'],function(){
        Route::post('follow','UserFollowController@store')->name('user.follow');
        Route::delete('unfollow','UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings','UsersController@followings')->name('users.followings');
        Route::get('followers','UsersController@followers')->name('users.followers');
        Route::get('favorites','UsersController@favorites')->name('users.favorites');
    });
        Route::resource('users','UsersController',['only'=>['index','show']]);
        Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);

    // 追加
    Route::group(['prefix' => 'microposts/{id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
    
    
    
});

//Route::resource('A','B',['only'=>['C']]);
//AはURL　Bはコントローラー名　Ｃはアクション（https://qiita.com/sympe/items/9297f41d5f7a9d91aa11）