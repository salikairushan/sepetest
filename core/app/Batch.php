<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'batches';
    public $timestamps = false;

    protected $fillable = [
        'batch_id',
        'stream',
        'type',
        'student_count',
        'year',
        'batch_no',
        'active'
    ];
}
