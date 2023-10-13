<?php
function formatData($data) {

    $filteredData = array();
    $discountGroupsDisplayed = array();
    $key = 1;
    foreach ($data as $item) {
        $discountGroup = $item['DiscountGroup'];
        $actualQuota = $item['ActualQuota'];
        $EndActivityDate = $item['EndActivityDate'];
        $today = date("Y-m-d");

        if ($EndActivityDate > $today && $actualQuota > 0 && !in_array($discountGroup, $discountGroupsDisplayed)) {
        
            $filteredData[$key] =  $item;
            
            $key++;
            $discountGroupsDisplayed[] = $discountGroup;
        }
    }
    
    return $filteredData;
}
?>