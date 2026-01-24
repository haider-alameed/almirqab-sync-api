<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use XiDanko\QueryFilter\HasFilter;


class School extends Model
{
    use HasFilter;

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
    protected $casts = [
        'almirqab_password' => 'encrypted',
    ];

    protected $hidden = [
        'almirqab_password',
    ];

    public function types()
    {
        return $this->belongsToMany(
            SchoolType::class,
            'school_rel_school_type',
            'school_id',
            'school_type_id'
        );
    }

    public function years()
    {
        return $this->belongsToMany(
            Year::class,
            'school_year',
            'school_id',
            'year_id'
        );
    }


}
