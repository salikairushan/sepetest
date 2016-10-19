<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'log_activities';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'activity_type',
        'status',
        'description'
    ];
}
