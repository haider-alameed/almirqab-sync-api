<?php

namespace App\Enums\Permissions;

use App\Enums\Concerns\HasValues;

enum ClassPermission: string
{
    use HasValues;

    case View = 'Class.view';
    case Index = 'Class.index';
    case List = 'Class.list';
    case Create = 'Class.create';
    case Update = 'Class.update';
    case Delete = 'Class.delete';

}
