<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    public $timestamps  = false;

    public function files()
    {
        return $this->hasMany(File::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'project_id');
    }
    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'project_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'project_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            $project->files()->delete();
            $project->meetings()->delete();
            $project->milestones()->delete();
            $project->tasks()->delete();
            $project->timesheets()->delete();

        });
    }
}
