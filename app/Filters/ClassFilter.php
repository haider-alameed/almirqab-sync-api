<?php

namespace App\Filters;

use App\Filters\Concerns\HasDateRangeFilter;
use Illuminate\Database\Eloquent\Builder;
use XiDanko\QueryFilter\Filter;

class ClassFilter extends Filter
{
    public function name(Builder $builder, $value): Builder
    {
        return $builder->where('name', 'like', "%{$value}%");
    }
}
