<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    public function notifiedUser(): HasMany
    {
        return $this->belongsTo(User::class,'notified_user_id');
    }
}
