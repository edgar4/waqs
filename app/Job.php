<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'salary',
        'type',
        'location',
        'time_posted',
        'raw_description',
    ];
}
