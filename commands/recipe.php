<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
include __DIR__ . '/../db_helper.php';
/**
 * @Issues:
 * - Add another button for load more
 */

$endpoint = 'http://www.recipepuppy.com/api/?';
$sizePerRequest = 2;
$defaultThumbnail = "http://arifbakery-patisserie.co.uk/wp-content/themes/nevia/images/shop-01.jpg";

function getRecipe($viand, $extra_context=null, $top=0) {
    global $sizePerRequest;
    // check previous db log
    $page = 1;
    $top = 0;
    if ($extra_context) {
        $log = getUserDataForCommand($extra_context["user_id"], "recipe");
        if ($log && $log->recipe ." ". $viand) { // condition is buggy
            $prevContext = (json_decode($log["context"], true));
            $prevContext = $prevContext["context"];
            $page = $prevContext["page"];
            $top = $prevContext["top"] + $prevContext["responseCount"];
            $originalResponseCount = $prevContext["originalResponseCount"];
            if ($prevContext["responseCount"] % $sizePerRequest != 0 ||
                $top >= $originalResponseCount) {
                // go to next page
                $page += 1;
                $top = 0;
            }
        }
    }

    $resp = queryApi($viand, $page);
    $originalResponse = $resp['results'];
    $elements = formatElements(
        array_slice($resp['results'], $top, $sizePerRequest), $viand);

    // log results to db
    if ($extra_context) {
        saveSessionData($extra_context["user_id"],
            "recipe", $viand, [
                "response" => $elements,
                "context" => [
                    "top" => $top,
                    "responseCount" => count($elements),
                    "page" => $page,
                    "originalResponseCount" => count($originalResponse)
                ]
            ]);
    }
    return formatAnswer($elements);
}

function queryApi($keyword, $page=1) {
    global $endpoint;
    $payload = array(
        'q' => $keyword,
        'p' => $page
    );
    $url = $endpoint . http_build_query($payload);
    $resp = json_decode(file_get_contents($url), true);
    return $resp;
}

function hasMore($keyword) {
    return count(queryApi($keyword)['results']) > 0;
}

function formatElements($results, $viand) {
    global $defaultThumbnail;
    $elements = array();
    foreach ($results as $key => $value) {
        $element = [
            'title' => $value['title'],
            'item_url' => $value['href'],
            'image_url' => $value['thumbnail'] ?: $defaultThumbnail,
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
    // @NOTE: Maybe change this to another CTA
    if (count($elements) > 0) {
        $lastElement = array_pop($elements);
        $postBackBtn = [
            "type"    => "postback",
            "title"   => "View more recipes",
            "payload" => "recipe " . $viand];
        array_push($lastElement["buttons"], $postBackBtn);
        array_push($elements, $lastElement);
    }
    return $elements;
}

function formatAnswer($elements) {
    if (count($elements) == 0) {
        $answer = ["text" => "😔 Can't find recipe. Try 🍰!"];
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

// Example:
// getRecipe('adobo', ['user_id' => "1234"]);
// $arr = ["one", "two", "three", "four", "five", "six"];
// print_r(array_slice($arr, 0, 2));
// print_r(array_slice($arr, 2, 2));
// print_r(array_slice($arr, 4, 2));
// call as many times to test pagination
