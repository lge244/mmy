<?php

function getNextMonthDays($date)
{
    $timestamp = strtotime($date);
    $arr = getdate($timestamp);
    if ($arr['mon'] == 12) {
        $year = $arr['year'] + 1;
        $month = $arr['mon'] - 11;
        $firstday = $year . '-0' . $month . '-01';
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    } else {
        $firstday = date('Y-m-01', strtotime(date('Y', $timestamp) . '-' . (date('m', $timestamp) ) . '-01'));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    }
    return array($firstday, $lastday);
}

print_r(getNextMonthDays(date('Y-m-d')));

