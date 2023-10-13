<?php
include __DIR__ . '/calculate_price.php';


function getOffers($duration, $startDate, $discount) {

    $offers = json_decode(file_get_contents('./data/'. ENV . '_prices.json'), true);
    $dateToCheck =  new DateTime($startDate);
    $results = [];

    foreach($offers as $offer) {

        $offerDuration = $offer['duration'];
        $offerStartDate = new DateTime($offer['startDate']);
        $offerEndDate = new DateTime($offer['endDate']);
        if ($duration === $offerDuration && $dateToCheck >= $offerStartDate && $dateToCheck <= $offerEndDate) {

            $offer['finalPrice'] = calculatePrice($offer['price'], $discount);
            $results[] = $offer;
        }
    }


    return $results;
}