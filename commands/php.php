<?php

function getPHP($curr) {
  $command = " Please try again.\nPHP <currency>";
  $curr = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $curr)));

  if(!empty($curr)){
    if(checkValidity($curr, 'currency') == 1){
      $output = "Adi".$command;
    }
  }else{
    $output = "Please input currency.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

