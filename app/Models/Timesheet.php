<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    public $table = 'project_timesheets';

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'timestamp_start',
        'timestamp_end',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
