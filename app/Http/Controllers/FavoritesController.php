<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store($micropostId)
    {
        //ユーザーが$micropostIdの投稿をfavoriteする
        \Auth::user()->favorite($micropostId);
        return back();
    }
    
    public function destroy($micropostId)
    {
        \Auth::user()->unfavorite($micropostId);
        return back();
    }
}
