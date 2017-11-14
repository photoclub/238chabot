<?php

/**
 * @Issues:
 * 1. Set better image default
 * 2. Add another button for load more
 * 3. Pick at most three items
 */

$endpoint = 'http://www.recipepuppy.com/api/?';

function getRecipe($viand) {
    $resp = queryApi($viand);
    $elements = formatElements(array_slice($resp['results'], 7));
    return formatAnswer($elements);
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

function formatElements($results) {
    $elements = array();
    foreach ($results as $key => $value) {
        $element = [
            'title' => $value['title'],
            'item_url' => $value['href'],
            'image_url' => $value['thumbnail'] ?: "http://arifbakery-patisserie.co.uk/wp-content/themes/nevia/images/shop-01.jpg",
            'subtitle' => $value['ingredients']
        ];
        if ($value['href']) {
            $element['buttons'] = [[
                'type' => 'web_url',
                'url' => $value['href'],
                'title' => 'Learn more'
            ]];
        }
        $elements[] = $element;
    }
    return $elements;
}

function formatAnswer($elements) {
    $answer = ["attachment" => [
        "type"    => "template",
        "payload" => [
            "template_type" => "list",
            "elements"      => $elements
        ],
    ]];
    return $answer;
}
