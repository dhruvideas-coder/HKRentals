<?php

namespace App\Helpers;

class RentalHelper
{
    /**
     * Calculate rental days between two points in time.
     *
     * Rules:
     *  - 24 hours = 1 rental day
     *  - Minimum is always 2 days (the 2-day base charge applies to anything < 48 h)
     *  - Beyond 48 h: ceil(total_seconds / 86400)
     *
     * @param  \DateTimeInterface|int|string  $start  Carbon, timestamp, or parseable string
     * @param  \DateTimeInterface|int|string  $end
     */
    public static function calculateDays(mixed $start, mixed $end): int
    {
        $startTs = self::toTimestamp($start);
        $endTs   = self::toTimestamp($end);

        $diffSeconds = max(0, $endTs - $startTs);

        return max(2, (int) ceil($diffSeconds / 86400));
    }

    private static function toTimestamp(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }
        if ($value instanceof \DateTimeInterface) {
            return $value->getTimestamp();
        }
        return (int) strtotime((string) $value);
    }
}
