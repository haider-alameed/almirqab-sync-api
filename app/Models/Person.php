<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Person extends Model
{
    protected $table = 'persons';
    protected $fillable = [
        'mongo_id',
        'almirqab_id',
        'school_id',
        'full_name',
        'date_of_birth',
        'address',
        'phone',
        'code',
        'type',
        'gender',
        'test',
        'longitude',
        'latitude',
    ];


}
