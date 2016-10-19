<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectUser extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'subject_users';
    public $timestamps = false;

    protected $fillable = [
        'userid',
        'subject_id',
        'type'
    ];
}
