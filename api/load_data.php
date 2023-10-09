<?php
function loadData($file) {
    $data = json_decode(file_get_contents($file), true);
    return $data;
}
?>