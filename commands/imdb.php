<?php

$endpoint = "http://www.omdbapi.com/?apikey=86030ddd&";
$defaultThumb = "https://cdn.theunlockr.com/wp-content/uploads/2012/04/IMDb.jpg";
$sizePerRequest = 3;


function getMovieRating($title, $extra_context=null) {
    global $sizePerRequest;
    $page = 1;
    $top = 0;
    $respSearch = querySearch($title, $page);

    $elements = [];
    foreach ($respSearch["Search"] as $key => $value) {
        $detail = queryDetail($value["imdbID"]);
        $elements[] = formatElement($detail);
    }

    $elements = array_slice($elements, $top, $sizePerRequest);
    $answer = formatAnswer($elements);
    // print_r($answer);
    return $answer;
}


function querySearch($title, $page) {
    global $endpoint;
    $payload = ["s" => $title, "page" => $page];
    $url = $endpoint . http_build_query($payload);
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


function formatElement($detail) {
    global $defaultThumb;
    $element = [
        "title" => $detail["Title"],
        "item_url" => "http://www.imdb.com/title/". $detail["imdbID"] ."/",
        "image_url" => $detail["Poster"] ?: $defaultThumb,
        "subtitle" => getRatings($detail),
        "buttons" => [[
            "type" => "web_url",
            "url"  => "http://www.imdb.com/title/". $detail["imdbID"] ."/",
            "title" => "Read reviews"
        ]]
    ];
    return $element;
}


function getRatings($detail) {
    $rating = "";
    foreach ($detail["Ratings"] as $key => $value) {
        $rating .= $value["Source"] ." ⭐ ". $value["Value"] ."\n";
    }
    return $rating;
}


function formatAnswer($elements) {
    if (count($elements) == 0) {
        $answer = ["text" => "😔 Can't find movie. Try 'Batman'!"];
    } else {
        $answer = ["attachment" => [
            "type"    => "template",
            "payload" => [
                "template_type" => "generic",
                "elements"      => $elements
            ],
        ]];
    }
    return $answer;
}


// getMovieRating("Batman");