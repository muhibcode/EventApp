<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    // public function userinfo()
    // {
    //     return $this->hasOne(Host::class, 'userinfo');
    // }

    public function following()
    {
        return $this->belongsToMany(UserInfo::class, 'followers', 'follower_id', 'following_id');
    }

    public function follower()
    {
        return $this->belongsToMany(UserInfo::class, 'followers', 'following_id', 'follower_id');
    }

    public function reqsender()
    {
        return $this->belongsToMany(UserInfo::class, 'follow_requests', 'req_receiver', 'req_sender');
    }

    public function reqreceiver()
    {
        return $this->belongsToMany(UserInfo::class, 'follow_requests', 'req_sender', 'req_receiver');
    }
}
