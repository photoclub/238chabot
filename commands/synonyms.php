<?php

function getSynonyms($word) {
  $command = " Please try again.\nPWNED <email address>";
  $email = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $email)));

<<<<<<< HEAD:commands/pwned.php
  if(!empty($email)){
    if(checkValidity($email, 'name') == 1){
=======
  if(!empty($word)){
    if(checkValidity($word, 'name') == 1){
>>>>>>> 0bb558d2f786f39770b2f69330e34d3884d83553:commands/synonyms.php
      $output = '';



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

