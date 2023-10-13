<?php
function getNextSaturday($date) {

    $timestamp = strtotime($date);

    $dayOfWeek = date("w", $timestamp);

    if ($dayOfWeek == 6) {
        $nextSaturday = date("Y-m-d", $timestamp);
    } else {
        $daysUntilSaturday = 6 - $dayOfWeek;
        $nextSaturdayTimestamp = $timestamp + ($daysUntilSaturday * 86400);
        $nextSaturday = date("Y-m-d", $nextSaturdayTimestamp);
    }

    return $nextSaturday;
    
    return $filteredData;
}
?>