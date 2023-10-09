<?php

include __DIR__ . '/api/load_translations.php';
include __DIR__ . '/api/load_data.php';
include __DIR__ . '/api/format_date.php';

$request_uri = $_SERVER['REQUEST_URI'];
$lang = '';

switch ($request_uri) {
    case '/' :
        $lang = 'fr';
        break;
    case '/en' :
        $lang = 'en';
        break;
    default:
        $lang = 'fr';
        break;
}

// A SUPPRIMER A LA MISE EN PROD
function randomBoolean() {
    $randomNumber = rand(0, 1);
    return $randomNumber % 2 === 0;
}

define("D", loadData(__DIR__ . '/data/ads.json'));
define("T", loadTranslations($lang, __DIR__ . '/data/translations.json'));

require __DIR__ . '/view.php';
?>