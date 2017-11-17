<?php

function getPwned($email) {
  $command = " Please try again.\nPWNED <email address>";
  $email = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $email)));

  if(!empty($email)){
    if(checkValidity($email, 'email') == 1){
      $output = '';
      $url = 'https://haveibeenpwned.com/api/v2/breachedaccount/charlotte.efren@gmail.com';
      $proc = json_decode(file_get_contents($url), true);

      file_put_contents('test-pwned.txt', $answer);



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

