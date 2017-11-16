<?php

function getGender($gender_name) {
  $command = " Please try again.\n GENDER <name>";

  if(checkValidity($gender_name, 'name') == 1){
    $url = 'https://api.genderize.io/?name='.$gender_name;
    $proc = file_get_contents($url);
    $proc = json_decode($proc, true); 
    $prob = $proc['probability'] * 100;
    $name = $proc['name'];

    if ($prob != 0){
      $output = ucfirst($name) . " is " . $prob  . "% " . $proc['gender'] . " name. This is based on ". $proc['count']. ' participants.';
    }else{
      if (str_word_count($name) != 1){
        if(is_numeric($name)){
          $output = "Numbers are not names.".$command;
        }else{
          $output = "We only recognize one word name. Separate ". ucwords($gender_name) ." into different queries.".$command;
        }
        //$output = str_word_count($name);
      }else{
        $output = "Sorry! ". ucfirst($name) . " is not a recognized name.".$command;
      }

      $answer = ['text' => $output];
    }
  }else{
    $answer = ['text' => "Name is using invalid characters.".$command ];
  }

  return $answer;
}