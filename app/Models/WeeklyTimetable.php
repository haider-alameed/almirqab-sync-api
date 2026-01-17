<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class WeeklyTimetable extends Model
{
    protected $table = 'weekly_timetables';

    protected $fillable = [
        'mongo_id',
        'almirqab_id',
        'school_id',
        'day',
        'order',
        'class_id',
        'course_id',
        'teacher_id',
        'year_id',
    ];




}
