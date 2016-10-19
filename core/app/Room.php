<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'rooms';
    public $timestamps = false;

    protected $fillable = [
        'room_no',
        'room_type',
        'student_count',
        'location',
        'active'
    ];
}
