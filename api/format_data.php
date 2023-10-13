<?php
include __DIR__ . './next_saturday.php';
include __DIR__ . './get_styles.php';
include __DIR__ . './get_offers.php';

function formatData($data, $durations) {
    $results = [];

    foreach ($durations as $duration) {
        $tempResult = [];
        $maxDiscountByStartDate = [];
        $discounts = [];
        $bestOffers = [];
        $bestOffer = [];
        $highestPrice = 0;

        foreach ($data as $entry) {
            $startDate = new DateTime($entry['startActivityDate']);
            $endDate = new DateTime($entry['endActivityDate']);
            $discount = $entry['discountValue'];
            $quota = $entry['actualQuota'];
            $today = new DateTime('now');
            $today->format('d-m-Y');


            if (($endDate > $today) && ($quota/$duration) > 1 && (!isset($maxDiscountByStartDate[$startDate->format('Y-m-d')]) || $discount > $maxDiscountByStartDate[$startDate->format('Y-m-d')])) {
                $maxDiscountByStartDate[$startDate->format('Y-m-d')] = $discount;

                $saturdayDate = new DateTime(getNextSaturday($entry['startActivityDate']));

                $tempResult[$saturdayDate->format('Y-m-d')] = [
                    'startDate' => $startDate->format('Y-m-d'),
                    'endDate' => $endDate->format('Y-m-d'),
                    'reduction' => $discount,
                ];

                if (!in_array($discount, $discounts)) {
                    $discounts[] = strval($discount);
                }
            } else if (($endDate > $today) && !isset($maxDiscountByStartDate[$startDate->format('Y-m-d')])) {

                $saturdayDate = new DateTime(getNextSaturday($entry['startActivityDate']));

                $tempResult[$saturdayDate->format('Y-m-d')] = [
                    'startDate' => $startDate->format('Y-m-d'),
                    'endDate' => $endDate->format('Y-m-d'),
                    'reduction' => 0,
                ];

                if (!in_array(0, $discounts)) {
                    $discounts[] = strval(0);
                }
            }
        }

        if (!empty($tempResult)) {
            $styles = getStyles($discounts, 140, 250);
            $tempResults = [];
    
            foreach($tempResult as $key => $tempSingle) {
                
                $offers = getOffers($duration, $key, $tempSingle['reduction']);
    
                $minPrice = PHP_INT_MAX;
                foreach($offers as $offer) {
                    $offerPrice = $offer['finalPrice'];
                    if ($offerPrice < $minPrice) {
                        $minPrice = $offerPrice;
                        if(empty($bestOffer) || $offerPrice < $bestOffer['price']) {
                            $bestOffer = array(
                                'startDate' => $tempSingle['startDate'],
                                'endDate' => $tempSingle['endDate'],
                                'price' => $offerPrice,
                        );
                        }

                    } else {
                        $highestPrice = $offerPrice;
                    }
                }
                if (!in_array($minPrice, $bestOffers)) {                
                    $bestOffers[] = $minPrice;
                }
                if (!empty($offers)) {
                    $style = $styles[$tempSingle['reduction']];
                    $tempSingle['style'] = $style;
                    $tempSingle['offers'] = $offers;
                    $tempResults[$key] = $tempSingle;
                }
                
        }
        
        }

        if (!empty($tempResults)) {

            ksort($tempResults);
            asort($bestOffers);
            $results[$duration]['weeks'] = $tempResults;      
            $results[$duration]['bestOffers'] = array_slice($bestOffers, 0, 2);
            $results[$duration]['highestPrice'] = $highestPrice;
            $results[$duration]['bestOffer'] = $bestOffer;
        }
        
    }

    return $results;
}
?>
