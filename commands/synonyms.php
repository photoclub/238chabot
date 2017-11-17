<?php

function getSynonyms($word) {
  $command = " Please try again.\nSYNONYMS <word>";
  $word = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $word)));

  if(!empty($word)){
    if(checkValidity($word, 'name') == 1){
      $output = '';
      $output = 'yes';

    }else{
      $output = "Word is using non-supported characters.".$command;
    }
  }else{
    $output = "Please input word.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

