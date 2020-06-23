<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{

    protected $fillable = [
        'user_id', 'logged_id', 'finished_date',
    ];
    public function feature_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
