<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class SchoolType extends Model
{

    protected $table = 'school_type';
protected  $fillable = [
    'school_type',
];
    public function schools()
    {
        return $this->belongsToMany(
            School::class,
            'school_rel_school_type',
            'school_type_id',
            'school_id'
        );
    }


}
