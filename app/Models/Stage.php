<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Stage extends Model
{

    protected $fillable = [
        'mongo_id',
        'almirqab_id',
        'school_id',
        'name',
        'postfix',
        'full_title',
        'name_en',
        'full_title_en',
        'fee',


    ];
    protected $table = 'stages';




}
