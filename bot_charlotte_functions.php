<?php

function getGender($gender_name){

  $url = 'https://api.genderize.io/?name='.$gender_name;

  $proc = file_get_contents($url);
  $proc = json_decode($proc, true); // second parameter will make $var an array rather than an object
  $prob = $proc['probability'] * 100;

  $name = $proc['name'];

  if ($prob != 0){
    $output = ucfirst($name) . " is " . $prob  . "% " . $proc['gender'] . " name. This is based on ". $proc['count']. ' participants.';
    return $output;
  }else{
    if (str_word_count($name) != 1){
      $output = "We only recognize one word name. Please separate ". ucwords($gender_name) ." into different queries.\nGENDER <name>";
    }else{
      $output = "Sorry! ". ucfirst($name) . " is not a recognized name. Please try again.\nGENDER <name>";
    }
    return $output;
  }
}


function getHistoryDate($history_date = NULL){
  if (!empty($history_date)){
    
    $check_date = explode('/',$history_date);
    $m = intval($check_date[0]);
    $d = intval($check_date[1]);

    $month_names = array( '1' => "January",'2' => "February",'3' => "March",'4' => "April",
                          '5' => "May",'6' => "June",'7' => "July",'8' => "August",'9' => "September",
                          '10' => "October",'11' => "November",'12' => "December" );

  
    if (preg_match("/^(?:[1-9]|0[1-9]|1[0-2])$/",$m) && preg_match("/^(?:[0-9]|0[1-9]|1[0-9]|2[0-9]|3[0-1])$/",$d)) {
      $pass = false;

      while($pass == false){
        if (($m == 1 || $m == 3 || $m == 5 || $m == 7 || $m == 8 || $m == 10 || $m == 12 ) && ($d <= 31 )){
          $pass = true;
        }elseif(( $m == 4 || $m == 6 || $m == 9 || $m == 11 ) && ($d <= 30 )){
          $pass = true;
        }elseif(( $m == 2 ) && ($d <= 29 )){
          $pass = true;
        }else{
          return 'Sorry, you miscounted the days for '. $month_names[$m].". Please try again. \nHISTORY <mm/dd>";
        }
      }

      if($pass==true){
        $url = 'http://numbersapi.com/'. $history_date .'/date';
        $proc = file_get_contents($url);
        $message = "History Trivia on \n". $month_names[$m] . " " . $d ."\n----------\n";
        return $message . $proc; 
      }

    } else {
        return "Invalid date format.\nHISTORY <mm/dd>";
    }
  }else{
    $url = 'http://numbersapi.com/random/date';
    $proc = file_get_contents($url);
    return "RANDOM History Trivia\n----------\n".$proc;
  }
  
}




?>