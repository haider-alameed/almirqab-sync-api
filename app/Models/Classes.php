<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Classes extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'mongo_id',
        'almirqab_id',
        'school_id',
        'stage_id',
        'supervisor_id',
        'title',
        'class_title',
        'full_title',
        'students_count',
        'timetable_count',
    ];





}
