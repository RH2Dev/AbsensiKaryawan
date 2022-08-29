<?php

namespace App\Helpers;

use Carbon\Carbon;

class HelperCarbon
{
    /**
     * @param string $date Y-m | Y-m-d
     */
    public static function calendar($date = null, $config = ['isStartOfMonth' => false, 'isWorkDay' => false])
    {
        $date = empty($date) ? Carbon::now() : Carbon::createFromDate($date);
        if (isset($config['isStartOfMonth']) && $config['isStartOfMonth']) {
            $entry = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();
        } else {
            $entry = $date->copy()->firstOfMonth()->startOfWeek(Carbon::SUNDAY);
            $end = $date->copy()->lastOfMonth()->endOfWeek(Carbon::SATURDAY);
        }

        $arr = [];
        while ($entry <= $end) {
            if (isset($config['isWorkDay']) && $config['isWorkDay']) {
                if ($entry->dayOfWeek != Carbon::SUNDAY && $entry->dayOfWeek != Carbon::SATURDAY) {
                    $arr[] = $entry->format('Y-m-d');
                }
                $entry->addDay();
            } else {
                $arr[] = $entry->format('Y-m-d');
                $entry->addDay();
            }
        }
        return $arr;
    }
}
