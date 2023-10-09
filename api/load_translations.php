<?php
function loadTranslations($lang, $file) {
    $translations = json_decode(file_get_contents($file), true);

    if (isset($translations[$lang])) {
        return $translations[$lang];
    } else {
        return $translations['en'];
    }
}
?>
