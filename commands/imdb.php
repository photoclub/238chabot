<?php
include_once __DIR__ . '/../db_helper.php';
$endpoint = "http://www.omdbapi.com/?apikey=86030ddd&";
$defaultThumb = "https://cdn.theunlockr.com/wp-content/uploads/2012/04/IMDb.jpg";
$sizePerRequest = 3;


class IMDB {

    function __construct() {}

    public function getMovieRating($title, $extra_context=null) {
        global $sizePerRequest;
        $page = 1;
        $top = 0;
        if ($extra_context) {
            $log = getUserDataForCommand($extra_context["user_id"], "imdb");
            if ($log && $log->recent_command == "imdb" && $log->message == $title) {
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

        $respSearch = $this->querySearch($title, $page);

        $originalResponse = [];
        foreach ($respSearch["Search"] as $key => $value) {
            $detail = $this->queryDetail($value["imdbID"]);
            $originalResponse[] = $this->formatElement($detail);
        }
        $elements = array_slice($originalResponse, $top, $sizePerRequest);

        if (count($elements) > 0) {
            $lastElement = array_pop($elements);
            $postBackBtn = [
                "type"    => "postback",
                "title"   => "View more reviews",
                "payload" => "imdb " . $title];
            array_push($lastElement["buttons"], $postBackBtn);
            array_push($elements, $lastElement);
        }

        $answer = $this->formatAnswer($elements);

        if ($extra_context) {
            saveSessionData(
                $extra_context["user_id"],
                "imdb",
                $title,
                [
                    "response" => $elements,
                    "context" => [
                        "top" => $top,
                        "responseCount" => count($elements),
                        "page" => $page,
                        "originalResponseCount" => count($originalResponse)
                    ]
                ]
            );
        }

        // print_r(json_encode($answer));
        return $answer;
    }


    private function querySearch($title, $page) {
        global $endpoint;
        $payload = ["s" => $title, "page" => $page];
        $url = $endpoint . http_build_query($payload);
        $resp = json_decode(file_get_contents($url), true);
        return $resp;
    }


    private function queryDetail($imdbID) {
        global $endpoint;
        $payload = ["i" => $imdbID];
        $url = $endpoint . http_build_query($payload);
        $resp = json_decode(file_get_contents($url), true);
        return $resp;
    }


    private function formatElement($detail) {
        global $defaultThumb;
        if ($detail["Poster"] == "N\/A") {
            $detail["Poster"] = $defaultThumb;
        }
        $element = [
            "title" => $detail["Title"],
            "item_url" => "http://www.imdb.com/title/". $detail["imdbID"] ."/",
            "image_url" => $detail["Poster"] ?: $defaultThumb,
            "subtitle" => $this->getRatings($detail),
            "buttons" => [[
                "type" => "web_url",
                "url"  => "http://www.imdb.com/title/". $detail["imdbID"] ."/",
                "title" => "Read reviews"
            ]]
        ];
        return $element;
    }


    private function getRatings($detail) {
        $rating = "";
        foreach ($detail["Ratings"] as $key => $value) {
            $rating .= $value["Source"] ." ⭐ ". $value["Value"] ."\n";
        }
        return $rating;
    }


    private function formatAnswer($elements) {
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

}

$imdb = new IMDB();
$imdb->getMovieRating("Batman", ['user_id' => "1234"]);
