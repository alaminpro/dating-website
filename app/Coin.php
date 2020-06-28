<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    public function user_coin()
    {
        return $this->belongsTo(User::class);
    }
}
