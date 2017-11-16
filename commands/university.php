<?php

function getUniversity($uni) {
  $command = " Please try again.\nIP <address>";
  $uni = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $uni)));

  if(!empty($uni)){
    if(checkValidity($uni, 'name') == 1){
      $output = '';
      $url = 'https://ipapi.co/'. $add .'/json/';
      $proc = json_decode(file_get_contents($url), true);

      $output = 'adi ka uni';

    }else{
      $output = "University name is using invalid characters.".$command;
    }
  }else{
    $output = "Please input the name of the university.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}