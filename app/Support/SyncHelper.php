<?php

namespace App\Support;

use Carbon\Carbon;

class SyncHelper
{
    public static function shouldSyncByUpdatedAt(array $row, ?Carbon $lastFetch, bool $syncIfMissingUpdatedAt = false): bool
    {
        if (! $lastFetch) return true;

        if (empty($row['updated_at'])) return $syncIfMissingUpdatedAt;

        return Carbon::parse($row['updated_at'])->gt($lastFetch);
    }
}
