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
  $prevContext = null;
  $done = false;
  $invalid = false;

  if(!empty($keyword)){
    // if(checkValidity($keyword, 'name') == 1){
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
      print_r($page." : ".$top. " : ".$prevContext["done"]."\n");
      print_r($url."\n");
      $proc = json_decode(file_get_contents($url), true);
      if (!isset($proc['_embedded']['quotes']) ||
          count($proc['_embedded']['quotes']) == 0) {
        $done = true;
      }

      if(!empty($proc['count'] != 0)){
        $output = $output . "****************************\n";
        $output = $output . "TRUMP's\nQUOTE ABOUT \n" . strtoupper($keyword) . "\n";
        $output = $output . "****************************\n";
        $responseCount = intval($proc['count']) - 1;
        $responseTotal = intval($proc['total']) - 1;
        // $rand = rand(0, $count);
        $response = $proc['_embedded']['quotes'][$top]['value'];
        $output = $output . $response;
      } else {
        $output = "Search keyword is not valid. ".$command;
        $invalid = true;
      }
    // } else{
    //   $output = "Search keyword is using invalid characters.".$command;
    // }
  } else{
    $output = "Please input a search keyword. ".$command;
  }

  // sanity check
  $pos = strpos($answer["text"], "Search keyword is not valid.");
  if (!($pos === false)) {
    $done = true;
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
                  "originalResponseCount" => $responseTotal,
                  "done" => $done
              ]
          ]
      );
  }

  $answer = ['text' => $output];
  // print_r($output."\n");
  return $answer;
}

// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
// getTrump('Life', ['user_id' => '1234']);
