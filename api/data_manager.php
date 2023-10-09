<?php
function sortData($csvData) {
    $organizedData = [];

    foreach ($csvData as $row) {
        $category = $row[0];
        $value = $row[1];

        if (!isset($organizedData[$category])) {
            $organizedData[$category] = [];
        }

        $organizedData[$category][] = $value;
    }

    return $organizedData;
}
?>