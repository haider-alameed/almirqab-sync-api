<?php

namespace App\Enums\Permissions;

use App\Enums\Concerns\HasValues;

enum CoursePermission: string
{
    use HasValues;

    case View = 'Stage.view';
    case Index = 'Stage.index';
    case List = 'Stage.list';
    case Create = 'Stage.create';
    case Update = 'Stage.update';
    case Delete = 'Stage.delete';

}
