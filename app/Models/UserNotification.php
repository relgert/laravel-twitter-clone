<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    use HasFactory;


    public function notifierUser(): BelongsTo
    {
        return $this->belongsTo(User::class,'notifier_user_id');
    }

    public function notifiedTweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class,'source_id');
    }
}
