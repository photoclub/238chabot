<?php
// include_once __DIR__ . '/../db_helper.php';
// include_once __DIR__  . '/helpers/helperFunctions.php';
	
function getTrump($keyword, $extra_context=null) {
  $command = " Please try again.\nTRUMP <keyword>";
  $keyword = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $keyword)));
  $sizePerRequest = 1;
  $page = 1;
  $top = 0;
  $total = 0;
  $response = null;
  $responseCount = 0;
  $responseTotal = 0;

  if(!empty($keyword)){
    if(checkValidity($keyword, 'name') == 1){
      if ($extra_context) {
        $log = getUserDataForCommand($extra_context["user_id"], "trump");
        if ($log && $log->recent_command == "trump" && $log->message == $keyword) {
          $prevContext = (json_decode($log["context"], true));
          $prevContext = $prevContext["context"];
          $page = $prevContext["page"];
          $top = $prevContext["top"] + 1;
          $originalResponseCount = $prevContext["originalResponseCount"];
          if ($prevContext["responseCount"] < $top) {
              // go to next page
              $page += 1;
              $top = 0;
          }
        }
      }

      $output = '';
      $url = 'https://api.tronalddump.io/search/quote?query='.$keyword.'&page='.$page;
      print_r($page." : ".$top."\n");
      print_r($url);
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc['count'] != 0)){
        $output = $output . "****************************\n";
        $output = $output . "TRUMP's\nQUOTE ABOUT \n" . strtoupper($keyword) . "\n";
        $output = $output . "****************************\n";
        $responseCount = intval($proc['count']) - 1;
        $responseTotal = intval($proc['total']) - 1;
        // $rand = rand(0, $count);
        $output = $output . $proc['_embedded']['quotes'][$top]['value'];
      }else{
        $output = "Search keyword is not valid.".$command;
      }
    }else{
      $output = "Search keyword is using invalid characters.".$command;
    }
  }else{
    $output = "Please input a search keyword.".$command;
  }

  if ($extra_context) {
      saveSessionData(
          $extra_context["user_id"],
          "trump",
          $keyword,
          [
              "response" => $response,
              "context" => [
                  "top" => $top,
                  "responseCount" => $responseCount,
                  "page" => $page,
                  "originalResponseCount" => $responseTotal
              ]
          ]
      );
  }

  $answer = ['text' => $output];
  print_r($answer);
  return $answer;
}

getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
// getTrump('Obama', ['user_id' => '1234']);
