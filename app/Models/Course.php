<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'mongo_id',
        'almirqab_id',
        'school_id',
        'order',
        'title',
    ];





}
