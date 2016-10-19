<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'gender',
        'priority',
        'role',
        'verified',
        'active'
    ];
}
