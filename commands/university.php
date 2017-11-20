<?php
// include_once __DIR__ . '/../db_helper.php';
// include_once __DIR__  . '/helpers/helperFunctions.php';

function getUniversity($uni, $extra_context=null) {
  $command = " Please try again.\nUniversity <name>";
  $uni = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $uni)));
  $proc = array();
  $originalProc = array();
  $sizePerRequest = 3;
  $top = 0;
  $done = false;

  if (empty($uni)) {
    $output = "Please input the name of the university.".$command;
  } else {
    $output = "University name is using invalid characters.".$command;
    if (checkValidity($uni, 'name')) {
      $output = '';
      $url = 'http://universities.hipolabs.com/search?name='.urlencode($uni).'&country=philippines';
      $proc = json_decode(file_get_contents($url), true);
      $originalProc = $proc;

      if (empty($proc)) {
        $output = "University is not found on this list.".$command;
      } else {
        // check previous session
        if ($extra_context) {
            $log = getUserDataForCommand($extra_context["user_id"], "university");
            $answer = ['text' => "There's nothing to do here. Type \"help\""];
            if ($log && $log->recent_command == "university" && $log->message == $uni) {
                $prevContext = (json_decode($log["context"], true));
                $prevContext = $prevContext["context"];
                $top = $prevContext["top"] + $prevContext["responseCount"];
                $originalResponseCount = $prevContext["originalResponseCount"];
                if ($prevContext["responseCount"] % $sizePerRequest != 0 ||
                    $top >= $originalResponseCount) {
                    // go to next page
                    $top = 0;
                }
            }
        }

        $proc = array_slice($proc, $top, $sizePerRequest);
        $unicount=count($proc);

        $output = $output . "****************************\n";
        $output = $output . "UNIVERSIT" . ($unicount > 1 ? 'IES ' : 'Y '). ":\n" . ucwords($uni) . "\n";
        $output = $output . "****************************\n";

        if($unicount == 1 ){
          $output = $output . "Name: " . $proc[0]['name'] . 
          "\nWeb Page: ". $proc[0]['web_pages'][0] .
           ") \n\n";
          $done = true;
        } else {
          $output = $output . "Webpages:\n";
          foreach ($proc as $key => $value) {
            $output .= $value['name'] .' '. join(' ', $value['web_pages']). "\n\n";
          }
          if ($top + $sizePerRequest >= count($originalProc) - 1) {
            $output .= 'End of results.';
            $done = true;
          } else {
            $output .= 'Type "next" for next set.';
          }
        }

        if(strlen($output) > 640){
          $output = "Your search is to broad, please refine search.".$command;
        }
      }
    } else {
      $output = "University name is using invalid characters.".$command;
    }
  }

  // save session data
  if ($extra_context) {
      saveSessionData(
          $extra_context["user_id"],
          "university",
          $uni,
          [
              "response" => $proc,
              "context" => [
                  "top" => $top,
                  "responseCount" => count($proc),
                  "originalResponseCount" => count($originalProc),
                  "done" => $done
              ]
          ]
      );
  }

  $answer = ['text' => $output];
  print_r($answer);
  return $answer;
}

// getUniversity('University of Cebu', ['user_id' => '1234']);
// getUniversity('University of the Philippines', ['user_id' => '1234']);
// getUniversity('University of the Philippines', ['user_id' => '1234']);
// getUniversity('University of Cebu', ['user_id' => '1234']);
// getUniversity('University of the Philippines', ['user_id' => '1234']);