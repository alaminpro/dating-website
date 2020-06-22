<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function feature_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
