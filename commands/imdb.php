<?php

$endpoint = "http://www.omdbapi.com/?apikey=86030ddd&";
$defaultThumb = "https://cdn.theunlockr.com/wp-content/uploads/2012/04/IMDb.jpg";


function getMovieRating($title, $extra_context=null) {
    $page = 1;
    $respSearch = querySearch($title, $page);
    foreach ($respSearch["Search"] as $key => $value) {
        $details = queryDetail($value["imdbID"]);
        print_r($details);
    }
}


function querySearch($title, $page) {
    global $endpoint;
    $payload = ["s" => $title, "page" => $page];
    $url = $endpoint . http_build_query($payload);
    print_r($url);
    $resp = json_decode(file_get_contents($url), true);
    return $resp;
}


function queryDetail($imdbID) {
    global $endpoint;
    $payload = ["i" => $imdbID];
    $url = $endpoint . http_build_query($payload);
    $resp = json_decode(file_get_contents($url), true);
    return $resp;
}


getMovieRating("Batman");