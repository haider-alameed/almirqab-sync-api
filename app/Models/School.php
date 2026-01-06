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


}
