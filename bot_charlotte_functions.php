<?php

function getGender($gender_name){
  if(checkValidity($gender_name, 'name') == 1){
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
        if(is_numeric($name)){
          $output = "Numbers are not names. Please try again.\nGENDER <name>";
        }else{
          $output = "We only recognize one word name. Please separate ". ucwords($gender_name) ." into different queries.\nGENDER <name>";
        }
        //$output = str_word_count($name);
      }else{
        $output = "Sorry! ". ucfirst($name) . " is not a recognized name. Please try again.\nGENDER <name>";
      }
      return $output;
    }
  }else{
    return "Your name is using invalid characters";
  }
}


function getHistoryDate($history_date = NULL){
  if (!empty($history_date)){
    if(checkValidity($history_date, 'date') == 1){
      $history_date = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $history_date)));

      $history_date = str_replace(array('/','-'),' ', $history_date);

      $cd_space = explode(' ',$history_date);
      $m = $cd_space[0];
      $d = $cd_space[1];

      if(is_numeric ($m) && is_numeric ($d)){
        $m = intval($m);
        $d = intval($d);

        if(($m != 0) && ($d != 0)){
          $month_names = array( '1' => "January",'2' => "February",'3' => "March",'4' => "April",
                                '5' => "May",'6' => "June",'7' => "July",'8' => "August",'9' => "September",
                                '10' => "October",'11' => "November",'12' => "December" );

        
          if (preg_match("/^(?:[1-9]|0[1-9]|1[0-2])$/",$m) && preg_match("/^(?:[0-9]|0[1-9]|1[0-9]|2[0-9]|3[0-1])$/",$d)) {
            $pass = false;

            do{
              if (($m == 1 || $m == 3 || $m == 5 || $m == 7 || $m == 8 || $m == 10 || $m == 12 ) && ($d <= 31 )){
                $pass = true;
              }elseif(( $m == 4 || $m == 6 || $m == 9 || $m == 11 ) && ($d <= 30 )){
                $pass = true;
              }elseif(( $m == 2 ) && ($d <= 29 )){
                $pass = true;
              }else{
                return 'Sorry, you miscounted the days for '. $month_names[$m].". Please try again. \nHISTORY <mm/dd>";
              }
            }while($pass == false);

            if($pass==true){
              $url = 'http://numbersapi.com/'. $m . '/' . $d .'/date';
              $proc = file_get_contents($url);
              $message = "History Trivia on \n". $month_names[$m] . " " . $d ."\n----------\n";
              $output = $message . $proc; 
            }

          } else {
            $output = "Invalid date. Please try again.\nHISTORY <mm/dd>";
          }
        }else{
          $output = "Dates must be more than 0. Please try again. \nHISTORY <mm/dd>";
        }

      }else{
        $output = "Dates must be numeric values. Please try again. \nHISTORY <mm/dd>";
      }
    }else{
      $output = "Using invalid characters. Please try again. \nHISTORY <mm/dd>";
    }


  }else{
    $url = 'http://numbersapi.com/random/date';
    $proc = file_get_contents($url);
    $output = "RANDOM History Trivia\n----------\n".$proc;
  }
  
  return $output;
}

function checkValidity($buffer,$type)
{
  switch ($type) {
    case 'name':
      return !preg_match('/[^A-Za-z0-9\-\ ]/', $buffer);
    case 'date':
      return !preg_match('/[^A-Za-z0-9\-\/\ ]/', $buffer);
    default:
      return 0;
  }
}


?>