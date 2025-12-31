<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class School extends Model
{

    protected $fillable = [
        'mongo_id',
        'name',
        'image',
        'closest_point',
        'manager_name',
        'manager_phone',
        'directorate',
        'governorate',
        'group_name',
        'gander',
        'active',
    ];
    protected $table = 'schools';

}
