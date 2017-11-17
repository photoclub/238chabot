<?php

function getSynonyms($word) {
  $command = " Please try again.\nPWNED <email address>";
  $email = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $email)));

  if(!empty($email)){
    if(checkValidity($email, 'name') == 1){
      $output = '';



      $output = $proc[0]['Title'];

    }else{
      $output = "Email Address is invalid.".$command;
    }
  }else{
    $output = "Please input Email Address.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

