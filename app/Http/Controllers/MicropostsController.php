<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if(\Auth::check()){//認証済みの場合、認証済みユーザを取得
            $user = \Auth::user();
            
            $microposts = $user->feed_microposts()->orderBy('created_at','desc')->paginate(10);
            
            $data = [
                'user'=> $user,
                'microposts'=>$microposts,];
            //viewでユーザーや投稿の情報を表示したいとき、コントローラでそれをDBから取得
            //viewの引数として渡す
        }
        
        return view('welcome',$data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'content'=>'required|max:255',
        ]);
        
        $request->user()->microposts()->create([
            'content'=>$request->content,
        ]);
        
    return back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::findOrFail($id);
        
        if(\Auth::id() === $micropost->user_id){
            $micropost->delete();
        }
        return back();
    }
    
    /**このmicropostをユーザがお気に入りする*/
    public function favorites_users()
    {
        return $this->belongsToMany(Micropost::class,'favorites','micropost_id','user_id')->withTimestamps();
    }
    
    
}
