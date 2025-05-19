<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon_hook extends Model
{
    use HasFactory;
    public $table = 'addon_hooks';
    protected $fillable = [
        'addon_id',
        'app_route',
        'addon_route',
        'dom',
    ];

    public function addon()
    {
        return $this->belongsTo(Addon::class, 'addon_id', 'id');
    }
}
