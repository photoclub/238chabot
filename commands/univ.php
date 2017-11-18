<?php

class University {
    function __construct() {
        $this->endpoint = "http://universities.hipolabs.com/search?";
    }

    public function getUniversity($keyword) {
        $response = $this->querySearch($keyword);
        $sizePerRequest = 3;
        $top = 0;
        
        $originalResponse = [];
        foreach ($response as $key => $value) {
            $originalResponse[] = $this->formatElement($value);
        }
        $elements = array_slice($originalResponse, $top, $sizePerRequest);
        $buttons =  [];
        if (count($elements) > 0) {
            $postBackBtn = [
                "type"    => "postback",
                "title"   => "View more",
                "payload" => "univ " . $keyword];
            array_push($buttons, $postBackBtn);
        }

        $answer = $this->formatAnswer($elements, $buttons);
        print_r($answer);
        return $answer;
    }

    private function querySearch($keyword) {
        $payload = ["country" => "philippines", "name" => $keyword];
        $url = $this->endpoint  . http_build_query($payload);
        $resp = json_decode(file_get_contents($url), true);
        return $resp;
    }

    private function formatElement($item) {
        $item_url = "http://universities.hipolabs.com/search?"; // change default
        if (count($item["domains"]) > 0) {
            $item_url = $item["domains"][0];
        } else if (count($item["web_pages"]) > 0) {
            $item_url = $item["web_pages"][0];
        }
        $element = [
            "title" => $item["name"],
            "item_url" => $item_url,
            "buttons" => [[
                "type" => "web_url",
                "url"  => $item_url,
                "title" => "More info"
            ]]
        ];
        return $element;
    }

    private function formatAnswer($elements, $buttons) {
        if (count($elements) == 0) {
            $answer = ["text" => "😔 Can't find university. Try 'University of the Philippines'!"];
        } else {
            $answer = ["attachment" => [
                "type"    => "template",
                "payload" => [
                    "template_type" => "list",
                    "top_element_style" => "COMPACT",
                    "elements" => $elements,
                    "buttons" => $buttons
                ],
            ]];
        }
        return $answer;
    }

}


$univ = new University();
$univ->getUniversity("University of the Philippines");