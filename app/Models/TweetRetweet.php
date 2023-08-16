<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TweetRetweet extends Model
{
    use HasFactory;

    public function user(): HasMany
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function tweet(): HasMany
    {
        return $this->belongsTo(User::class,'tweet_id');
    }
}
