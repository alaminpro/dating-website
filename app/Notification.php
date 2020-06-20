<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function notify_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
