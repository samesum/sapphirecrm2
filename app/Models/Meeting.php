<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    public $timestamps  = false;
    public $table       = 'project_meetings';
    protected $fillable = [
        'project_id',
        'title',
        'time',
        'link',
        'audience',
        'timestamp_created',
        'timestamp_meeting',
    ];
}
