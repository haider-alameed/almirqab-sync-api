<?php

namespace App\Filters\Concerns;

use App\ValueObjects\DateRange;
use Illuminate\Database\Eloquent\Builder;

trait HasDateRangeFilter
{
    public function dateRange(Builder $builder, $value): Builder
    {
        $dateRange = DateRange::fromString($value);
        return $builder
            ->whereDate('created_at', '>=', $dateRange->start)
            ->whereDate('created_at', '<=', $dateRange->end);
    }
}
