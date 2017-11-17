<?php

function getSynonyms($word) {
  $command = " Please try again.\nPWNED <email address>";
  $email = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $email)));

  if(!empty($word)){
    if(checkValidity($word, 'name') == 1){
      $output = '';
      $url = 'https://haveibeenpwned.com/api/v2/breachedaccount/charlotte.efren@gmail.com';
      $proc = json_decode(file_get_contents($url), true);

      file_put_contents('test-pwned.txt', $answer);



      $output = $proc[0]['Title'];

    }else{
      $output = "Word is using non-supported characters.".$command;
    }
  }else{
    $output = "Please input word.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

