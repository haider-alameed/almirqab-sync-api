<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FetchRun extends Model
{
    protected $fillable = [
        'source',
        'started_at',
        'finished_at',
        'items_count',
        'status',
        'error',
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];
}
