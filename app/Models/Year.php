<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Year extends Model
{

    protected $table = 'years';
    protected $fillable = [
        'year',
        'almirqab_id',
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
