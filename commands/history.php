<?php

function getHistory($history_date = NULL){

  $command = " Please try again.\nHISTORY <mm/dd>";
  if (!empty($history_date)){
    if(checkValidity($history_date, 'date') == 1){
      $history_date = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $history_date)));
      $history_date = str_replace(array('/','-'),' ', $history_date);

      $cd_space = explode(' ',$history_date);
      $m = $cd_space[0];
      $d = $cd_space[1];

      if(count($cd_space) < 3 ){
        if((!empty($d) || !is_null($d))){
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
                  $output = 'Sorry, you miscounted the days for '. $month_names[$m].". ".$command;
                  break;
                }
              }while($pass == false);

              if($pass==true){
                $url = 'http://numbersapi.com/'. $m . '/' . $d .'/date';
                $proc = file_get_contents($url);
                $message = "History Trivia on \n". $month_names[$m] . " " . $d ."\n----------\n";
                $output = $message . $proc; 
              }

            } else {
              $output = "Invalid date.".$command;
            }
          }else{
            $output = "Dates must be more than 0.".$command;
          }
        }else{
          $output = "Date is missing one more value.".$command;
        }
      }else{
        $output = "Date have more than 2 values.".$command;
      }
    }else{
      $output = "Using invalid characters.".$command;
    }

  }else{
    $url = 'http://numbersapi.com/random/date';
    $proc = file_get_contents($url);
    $output = "RANDOM History Trivia\n----------\n".$proc;
  }

  $answer = ['text' => $output];
  return $answer;
}