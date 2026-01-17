<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Teacher extends Model
{
    protected $table = 'teachers';

    protected $fillable = [
        'almirqab_id',
        'person_id',
        'school_id',
        'year_id',
        'migrated',
        'app_state',
        'state_date',
        'teacher_in_api',
        'gender',
        'image',
        'mongo_created_at',
        'mongo_updated_at',
    ];




}
