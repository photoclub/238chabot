<?php

$endpoint = 'http://www.recipepuppy.com/api/?';

function getRecipe($viand) {
    $resp = queryApi($viand);
    $prompt = "Craving for {$viand}?\n";
    foreach ($resp['results'] as $key => $value) {
        $prompt .= "{$key} - ".$value['title']."\n";
    }
    $prompt .= 'Pick a number.';
    $prompt .= hasMore($viand) ? "\nOr get 'More'": '';
    return $prompt;
}

function queryApi($keyword) {
    global $endpoint;
    $payload = array(
        'q' => $keyword,
        'p' => 1
    );
    $url = $endpoint . http_build_query($payload);
    $resp = json_decode(file_get_contents($url), true);
    return $resp;
}

function hasMore($keyword) {
    return count(queryApi($keyword)['results']) > 0;
}

getRecipe('adobo');