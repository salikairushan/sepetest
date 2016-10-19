<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'slots';
    public $timestamps = false;

    protected $fillable = [
        'time',
        'batch_id',
        'subject_id',
        'room_id',
        'type'
    ];
}
