<?php

$endpoint = 'http://www.recipepuppy.com/api/?';

function getRecipe($viand, $sender) {
    $resp = queryApi($viand);
    // $prompt = "Craving for {$viand}?\n";
    // foreach ($resp['results'] as $key => $value) {
    //     $prompt .= "{$key} - ".$value['title']."\n";
    // }
    // $prompt .= 'Pick a number.';
    // $prompt .= hasMore($viand) ? "\nOr get 'More'": '';
    // return $prompt;
    $response = formatAnswer($resp['results'], $sender);
    return $response;
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

function formatAnswer($results, $sender) {
    $elements = array();
    foreach ($results as $key => $value) {
        $element = [
            'title' => $value['title'],
            'item_url' => $value['href'],
            'image_url' => $value['thumbnail'],
            'subtitle' => $value['ingredients']
        ];
        $elements[] = $element;
    }
    $answer = ["attachment" => [
        "type" => "template",
        "payload" => [
            "template_type" => "list",
            "elements" => $elements
        ]
    ]];
    $answer = formatRequest($sender, $answer);
    return $answer;
}

function formatRequest($sender, $message){
  $jsonData=[
    'recipient' => [ 'id' => $sender ],
    'message' => $message
  ];
  return json_encode($jsonData);
}

// getRecipe('adobo', 'asdf');
