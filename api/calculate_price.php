<?php
function calculatePrice($price, $discountPercentage) {

    if (!$discountPercentage) {
        return round(intval($price));
    }

    $floatPrice = floatval($price);

    $discountedPrice = $floatPrice - ($floatPrice * $discountPercentage / 100);
    $roundedDiscountedPrice = round($discountedPrice, 0);

    return $roundedDiscountedPrice;
}