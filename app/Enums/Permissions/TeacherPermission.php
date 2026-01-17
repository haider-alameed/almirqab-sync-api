<?php

namespace App\Enums\Permissions;

use App\Enums\Concerns\HasValues;

enum TeacherPermission: string
{
    use HasValues;

    case View = 'Teacher.view';
    case Index = 'Teacher.index';
    case List = 'Teacher.list';
    case Create = 'Teacher.create';
    case Update = 'Teacher.update';
    case Delete = 'Teacher.delete';

}
