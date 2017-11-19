<?php

function getUni($uni, $extra_context=null, $top=0) {
  $command = " Please try again.\nUniversity <name>";
  $uni = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $uni)));

  if(!empty($uni)){
    if(checkValidity($uni, 'name') == 1){
      $output = '';

      /* log user data */
        if ($extra_context) {
            $log = getUserDataForCommand($extra_context["user_id"], "university");
            if ($log && $log->recent_command == "university" && $log->message == $title) {
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
      /* log user data */

      $resp = queryUniApi($uni);
      $originalResponse = $resp;
      $elements = formatUniElements(
          array_slice($resp['results'], $top, $sizePerRequest), $uni);

      // log results to db
      if ($extra_context) {
          saveTextSessionData($extra_context["user_id"],
              "university", $uni, [
                  "response" => $elements,
                  "context" => [
                      "top" => $top,
                      "responseCount" => count($elements),
                      "page" => $page,
                      "originalResponseCount" => count($originalResponse)
                  ]
              ]);
      }
      return formatUniAnswer($elements);


 
    }else{
      $output = "University name is using invalid characters.".$command;
    }
  }else{
    $output = "Please input the name of the university.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

function queryUniApi($keyword) {
    $url = 'http://universities.hipolabs.com/search?name='.urlencode($keyword).'&country=philippines';
    $resp = json_decode(file_get_contents($url), true);
    file_put_contents('test-response.txt', [implode(" ",$resp), $url]);
    return $resp;
}


function hasUniMore($keyword) {
    return count(queryUniApi($keyword)['results']) > 0;
}

function formatUniElements($results, $uni) {
    $elements = '';
    foreach ($uni as $key => $value) {

      $elements = $elements . "Name: " . $value[0]['name'] . 
          "\nWeb Page: ". $value[0]['web_pages'][0] .
           ") \n\n";
        /*
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
        $elements[] = $element;*/

    }
    /*
    // @NOTE: Maybe change this to another CTA
    if (count($elements) > 0) {
        $lastElement = array_pop($elements);
        $postBackBtn = [
            "type"    => "postback",
            "title"   => "View more recipes",
            "payload" => "recipe " . $viand];
        array_push($lastElement["buttons"], $postBackBtn);
        array_push($elements, $lastElement);
    } */
    return $elements;
}

function formatUniAnswer($elements) {
    if (count($elements) == 0) {
        $answer = ["text" => "😔 Can't find recipe. Try 🍰!"];
    } else {
      $answer = $answer;
    }
    return $answer;
}