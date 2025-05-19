<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    public $timestamps  = false;
    public $table       = 'project_files';
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'file',
        'extention',
        'size',
        'timestamp_start',
        'timestamp_end',
    ];

    public static function upload_file($file, $path = null)
    {
        if ($file) {
            $file_name = Str::random(20) . '.' . $file->extension();
            $path      = 'public/uploads/' . $path;
            $file->move($path, $file_name);
            return asset($path . '/' . $file_name);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
