<?php


function getUni($uni) {
  $command = " Please try again.\nUniversity <name>";
  $uni = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $uni)));

  if(!empty($uni)){
    if(checkValidity($uni, 'name') == 1){
      $output = '';
      $url = 'http://universities.hipolabs.com/search?name='.urlencode($uni).'&country=philippines';
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc)){
        $unicount=count($proc);

        $output = $output . "****************************\n";
        $output = $output . "UNIVERSIT" . ($unicount > 1 ? 'IES ' : 'Y '). ":\n" . ucwords($uni) . "\n";
        $output = $output . "****************************\n";

        if($unicount == 1 ){
          $output = $output . "Name: " . $proc[0]['name'] . 
          "\nWeb Page: ". $proc[0]['web_pages'][0] .
           ") \n\n";
        }else{
          $output = $output . "Webpages:\n";
          for($x = 0; $x < $unicount; $x++ ){
            for($y = 0; $y < $unicount; $y++ ){
              $output = $output . trim($proc[$x]['web_pages'][$y]) ." ";
            }
          }
        }

        if(strlen($output) > 640){
          $output = "Your search is to broad, please refine search.".$command;
        }

      }else{
        $output = "University is not found on this list.".$command;
      }
    }else{
      $output = "University name is using invalid characters.".$command;
    }
  }else{
    $output = "Please input the name of the university.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}


function getUniversity($uni) {
  $command = " Please try again.\nUniversity <name>";
  $uni = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $uni)));

  if(!empty($uni)){
    if(checkValidity($uni, 'name') == 1){
      $output = '';
      $url = 'http://universities.hipolabs.com/search?name='.urlencode($uni).'&country=philippines';
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc)){
        $unicount=count($proc);

        $output = $output . "****************************\n";
        $output = $output . "UNIVERSIT" . ($unicount > 1 ? 'IES ' : 'Y '). ":\n" . ucwords($uni) . "\n";
        $output = $output . "****************************\n";

        if($unicount == 1 ){
          $output = $output . "Name: " . $proc[0]['name'] . 
          "\nWeb Page: ". $proc[0]['web_pages'][0] .
           ") \n\n";
        }else{
          $output = $output . "Webpages:\n";
          for($x = 0; $x < $unicount; $x++ ){
            for($y = 0; $y < $unicount; $y++ ){
              $output = $output . trim($proc[$x]['web_pages'][$y]) ." ";
            }
          }
        }

        if(strlen($output) > 640){
          $output = "Your search is to broad, please refine search.".$command;
        }

      }else{
        $output = "University is not found on this list.".$command;
      }
    }else{
      $output = "University name is using invalid characters.".$command;
    }
  }else{
    $output = "Please input the name of the university.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}