<?php

function getPwned($email) {
  $command = " Please try again.\nPWNED <email address>";
  $email = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $email)));

  if(!empty($email)){
    if(checkValidity($email, 'email') == 1){
      $output = "Adi pwned";
    }else{
      $output = "Phone Number is using invalid characters.".$command;
    }
  }else{
    $output = "Please input Phone Number.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

