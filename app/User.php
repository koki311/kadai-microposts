<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    /**
     * このユーザー（左）がフォロー中のユーザー（右）　左から右
     */ 
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
     /**
     * このユーザー（左）をフォロー中のユーザー（右）　右から左
     */ 
    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts','followings','followers']);
    }
    
    
    /**
     * $userIdで指定されたユーザをフォローする
     */
    public function follow($userId)
    {
        //すでにフォローしてるか？
        $exist = $this->is_following($userId);
        //対象が自分自身か？
        $its_me = $this->id == $userId;
        
        if($exist || $its_me){
            //フォロー済みまたは自分自身の場合は何もしない
            return false;
        }else{
            //上記以外の場合はフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    /**
     * $userIdで指定されたユーザーをアンフォローする
     */
    public function unfollow($userId)
    {
        //すでにフォローしている？
        $exist = $this->is_following($userId);
        //対象が自分自身？
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
            //フォロー済みかつ自分自身ではない
            $this->followings()->detach($userId);
            return true;
        }else{
            //上記以外の場合は何もしない
            return  false;
        }
    }
    
    /**
     * 指定された$userIdのユーザーをこのユーザがフォロー中か調べる。フォロー中ならtrueを返す
     */
    public function is_following($userId)
    {
        //フォロー中ユーザーの中に$userIdのものが存在するか？
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    
}
