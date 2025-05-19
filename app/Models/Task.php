<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $timestamps  = false;
    public $table       = 'project_tasks';
    protected $fillable = [
        'project_id',
        'milestone_id',
        'title',
        'start_date',
        'end_date',
    ];
}
