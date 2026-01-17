<?php

namespace App\Enums\Permissions;

use App\Enums\Concerns\HasValues;

enum WeeklyTimetablePermission: string
{
    use HasValues;

    case View = 'WeeklyTimetable.view';
    case Index = 'WeeklyTimetable.index';
    case List = 'WeeklyTimetable.list';
    case Create = 'WeeklyTimetable.create';
    case Update = 'WeeklyTimetable.update';
    case Delete = 'WeeklyTimetable.delete';

}
