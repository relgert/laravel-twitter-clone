<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollower extends Model
{
    use HasFactory;




    public function followed(): HasMany
    {
        return $this->belongsTo(User::class,'followed_user_id');
    }

    public function follower(): HasMany
    {
        return $this->belongsTo(User::class,'follower_user_id');
    }
}
