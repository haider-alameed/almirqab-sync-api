<?php

namespace App\Support;

final class MongoObjectId
{
    public static function generate(): string
    {
        static $inc = null;

        $ts   = pack('N', time());   // 4 bytes
        $rand = random_bytes(5);     // 5 bytes

        if ($inc === null) $inc = random_int(0, 0xFFFFFF);
        $inc = ($inc + 1) & 0xFFFFFF;

        $cnt = substr(pack('N', $inc), 1); // 3 bytes

        return bin2hex($ts . $rand . $cnt); // 24 hex
    }
}
