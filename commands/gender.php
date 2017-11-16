<?php

function getGender($gender_name) {
  $command = " Please try again.\nGENDER <name>";


  if(checkValidity($gender_name, 'name') == 1){
    $output = '';
    $arrname = explode(' ',$gender_name);
    $arrlen = count($arrname);
    for($x = 0; $x < $arrlen; $x++) {
      $url = 'https://api.genderize.io/?name='.$arrname[$x];
      $proc = json_decode(file_get_contents($url), true);
      $prob = $proc['probability'] * 100;
      $name = $proc['name'];

      if ($prob != 0){
        if ($arrlen != 1){
          $output = $output . "Name #" . ($x+1) ."\n";
        }
        $output = $output . ucfirst($name) . " is " . $prob  . "% " . $proc['gender'] . " name. This is based on ". $proc['count']. " participants.\n\n";
      }else{
        if($arrlen != 0)
          if ($arrlen != 1){
            $output = $output . "Name #" . ($x+1) ."\n";
          }

          $output = $output . "Sorry! ". ucfirst($name) . " is not a recognized name.";

          if($arrlen == 1){
           $output = $output .$command . "\n\n";
          }else{
            $output = $output . "\n\n";
          }
        }else{
          $output = "Please input a name.".$command;
        }
      }
    }
  }else{
    $output = "Name is using invalid characters.".$command;
  }
  
  $answer = ['text' => $output];
  return $answer;
}