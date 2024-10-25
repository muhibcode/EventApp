<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function activities()
    {
        return $this->belongsToMany(Event::class, 'event_attendees');
    }

    public function userinfo()
    {
        return $this->belongsTo(UserInfo::class, 'userinfo');
    }
    // public function activityHosted()
    // {
    //     return $this->hasMany(Activity::class, 'activity_attendees');
    // }

}
