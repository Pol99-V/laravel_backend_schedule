<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'id', 'schedule_event_id', 'start', 'end', 'dayOfWeek'
    ];
    protected $hidden = [
        'schedule_event_id','created_at', 'updated_at'
    ];
   
}
