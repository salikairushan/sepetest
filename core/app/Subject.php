<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'subjects';
    public $timestamps = true;

    protected $fillable = [
        'subject_code',
        'Name'
    ];
}
