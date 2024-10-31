<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['src'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    function getSrcAttribute()
    {
        return asset("storage/{$this->filename}");
    }

}
