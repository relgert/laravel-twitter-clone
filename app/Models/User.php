<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserFollower;
use Auth;


use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected $appends= ['followed_by_user'];

    public function getFollowedByUserAttribute()
    {
        $follow = null;
        if(Auth::user()){
            $follow = UserFollower::where('followed_user_id', $this->id)->where('follower_user_id',Auth::user()->id)->first();
        }
        return ($follow)?true:false;
    }

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class,'user_id');
    }

    public function followers(): HasMany
    {
        return $this->hasMany(UserFollower::class,'followed_user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotifications::class,'notified_user_id');
    }


    public function increment_counter($counter = 'count_favorites'){
        $this->increment($counter, 1);
    }

    public function decrement_counter($counter = 'count_favorites'){
        $this->decrement($counter, 1);
    }
}
