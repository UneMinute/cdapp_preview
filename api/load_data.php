<?php
function loadData($url) {

$options = [
    'http' => [
        'method' => 'GET',
        'header' => 'User-Agent: VotreApplication',
        'ignore_errors' => true,
        'timeout' => 10,
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true,
    ],
];

$context = stream_context_create($options);

$jsonData = file_get_contents($url, false, $context);

if ($jsonData === false) {
    die("Impossible de récupérer le JSON depuis l'URL.");
}

$data = json_decode($jsonData, true);

if ($data === null) {
    die("Erreur lors de l'analyse du JSON.");
}

return $data;
}
?>