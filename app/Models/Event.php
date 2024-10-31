<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(Attendee::class, 'event_attendees');
    }

    public function hostedBy()
    {
        return $this->hasOne(Host::class, 'event');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comment_table');
    }

    public function images()
    {
        return $this->hasMany(EventImage::class, 'event_id');
    }
}
