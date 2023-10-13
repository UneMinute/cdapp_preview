<?php
include __DIR__ . '/api/load_translations.php';
include __DIR__ . '/api/load_data.php';
include __DIR__ . '/api/format_date.php';
include __DIR__ . '/api/format_data.php';
define("ENV", "ads");

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

$durations = [6, 7, 8, 9];
$data = loadData('https://8pfh21wbh7.execute-api.eu-west-3.amazonaws.com/staging/' . ENV);


define("D", formatData($data, $durations));
define("T", loadTranslations($lang, __DIR__ . '/data/translations.json'));
require __DIR__ . '/view.php';
?>