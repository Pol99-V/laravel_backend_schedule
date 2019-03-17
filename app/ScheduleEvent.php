<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleEvent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'title', 'color'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $dates = ['deleted_at'];
}
