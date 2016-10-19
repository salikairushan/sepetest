<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'notifications';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'type',
        'url',
        'header_text',
        'detail_text',
        'view_status'
    ];
}
