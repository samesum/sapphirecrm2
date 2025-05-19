<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    public $timestamps  = false;
    public $table       = 'project_milestones';
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'tasks',
        'progress',
        'timestamp_start',
        'timestamp_end',
    ];

    protected $casts = [
        'tasks' => 'array',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
