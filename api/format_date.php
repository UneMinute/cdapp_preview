<?php


function formatDate($lang, $date, $full = false, $year = false) {

    $locale = $lang === 'fr' ? 'fr_FR.utf8' : 'en_GB.utf8';
    setlocale(LC_TIME, $lang);

    $newDate = new DateTime($date);
    
    // Formater la date en utilisant strftime
    if ($full) {
        $format = $lang === 'fr' ? '%d %B' : '%B %d';
    } else {
        $format = $lang === 'fr' ? '%d/%m' : '%m/%d';
    }
    
    $formattedDate = utf8_encode(strftime($format, $newDate->getTimestamp()));
    return $formattedDate;
}

?>