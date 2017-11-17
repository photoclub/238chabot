<?php

function getPHP($curr) {
  $command = " Please try again.\nPHP <currency>";
  $curr = strtoupper(trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $curr))));


  if(!empty($curr)){
    if(checkValidity($curr, 'currency') == 1){
      $output = '';
      $curr = str_replace(array('+', '-'), '' , $curr);


      $url = 'https://api.fixer.io/latest?base=PHP&symbols=' . $curr;
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc['rates'])){
        $date = strtotime($proc['date']);

        $output = $output . "****************************\n";
        $output = $output . "Currency Exchange for \n";
        $output = $output . date("F jS, Y", $date )."\n";
        $output = $output . "****************************\n";
        $output = $output . 'PHP to ' . $curr . "\n";
        $output = $output . "Rate: ".$proc['rates'][$curr] . "\n";
      }else{
        if($curr == 'PHP'){
          $output = "Cannot exchange PHP for PHP.".$command;
        }else{
          $output = "Currency not found.".$command;
        }
      }

    }else{
      $output = "Currency is using invalid characters.".$command;
    }
  }else{
    $output = "Please input currency.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}





