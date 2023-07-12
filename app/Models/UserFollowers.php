<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollowers extends Model
{
    use HasFactory;

    public function user(): HasMany
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function follower(): HasMany
    {
        return $this->belongsTo(User::class,'follower_user_id');
    }
}
