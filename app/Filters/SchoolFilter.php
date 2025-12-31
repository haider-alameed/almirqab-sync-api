<?php

namespace App\Filters;

use App\Filters\Concerns\HasDateRangeFilter;
use Illuminate\Database\Eloquent\Builder;
use XiDanko\QueryFilter\Filter;

class SchoolFilter extends Filter
{
    public function name(Builder $builder, $value): Builder
    {
        return $builder->where('name', 'like', "%{$value}%");
    }
}
