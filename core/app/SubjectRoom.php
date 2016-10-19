<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectRoom extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'subjects_rooms';
    public $timestamps = true;

    protected $fillable = [
        'room_id',
        'subject_id',
        'type'
    ];
}
