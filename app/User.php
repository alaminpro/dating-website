<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = ['age'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'interest_user');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id');
    }

    public function isFollows(User $user)
    {
        return $this->follows()->where('user_id', $user->id)->pluck('id');
    }

    public function follow($userId)
    {
        $this->follows()->attach($userId);
        return $this;
    }

    public function unfollow($userId)
    {
        $this->follows()->detach($userId);
        return $this;
    }

    public function isFollowing($userId)
    {
        return (boolean) $this->follows()->where('follow_id', $userId)->first(['id']);
    }

    public function isFollowEach($user_id)
    {
        if ($user_id) {
            $follower = $this->follows()->where('follow_id', $user_id)->count();
            $following = $this->following()->where('user_id', $user_id)->count();
            if ($follower && $following) {
                return true;
            }
            return false;
        }
    }
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['birthday'])->age;
    }

    // public function scopeAgeCheck($query, $min, $max)
    // {
    //     return $query->whereBetween('age', [$min, $max]);

    // }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'user_like', 'user_id', 'receive_id')->withPivot('type');
    }

    public function unread()
    {
        $user_id = $this->id;
        return Message::where('seen', 0)->where('user_id', '!=', $user_id)->leftJoin('conversations', 'messages.conversation_id', '=', 'conversations.id')->where(function (Builder $query) use ($user_id) {
            $query->where('sender_id', $user_id)->orWhere('receive_id', $user_id);
        })->get();
    }
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
