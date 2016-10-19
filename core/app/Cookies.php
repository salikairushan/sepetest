<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cookies extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cookies';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'content',
        'content2',
        'time_period'
    ];
}
