<?php

namespace App\Libraries;
use DateTime;

class StartDateBuilder
{
    const DEFAULT_DELTA_DAYS = -1;
    const DEFAULT_DELTA_HOURS = 0;
    const HISTORICAL_FLAG = -1;

    public static function getStartDate(): string
    {
        $delta_days = request('days', self::DEFAULT_DELTA_DAYS);
        $delta_hours = request('hours', self::DEFAULT_DELTA_HOURS);

        if ($delta_days != self::HISTORICAL_FLAG) {
            $delta_seconds = $delta_days * 24 * 60 * 60 + $delta_hours * 60 * 60;
            $start_date_seconds = (new DateTime())->getTimestamp() - $delta_seconds;
            $start_date = self::createDate($start_date_seconds);
        }
        else
            $start_date = self::createDate(0);

        return $start_date;
    }

    private static function createDate($timestamp): string
    {
        return (new DateTime())->setTimestamp($timestamp)->format("Y-m-d H:i:s");
    }
}
