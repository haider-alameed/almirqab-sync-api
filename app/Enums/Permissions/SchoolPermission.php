<?php

namespace App\Enums\Permissions;

use App\Enums\Concerns\HasValues;

enum SchoolPermission: string
{
    use HasValues;

    case View = 'School.view';
    case Index = 'School.index';
    case List = 'School.list';
    case Create = 'School.create';
    case Update = 'School.update';
    case Delete = 'School.delete';

}
