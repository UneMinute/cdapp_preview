<?php
function getStyles($percentages, $minHeight, $maxHeight) {

    $styles = [];

    $minPercentage = min($percentages);
    $maxPercentage = max($percentages);

    foreach ($percentages as $percentage) {

        if ($percentage == 0) {
            $height = $maxHeight;
        } else {
            $scaled = 1 - (log($percentage) / log($maxPercentage));
            $height = $minHeight + $scaled * ($maxHeight - $minHeight);
        }

        $styles[$percentage] = intval($height);
    }    

    return $styles;
}
?>