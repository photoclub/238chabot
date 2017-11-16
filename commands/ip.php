<?php

function getIP($add) {
  $command = " Please try again.\nIP <address>";
  $add = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $add)));

  if(!empty($add)){
    if(checkValidity($add, 'ip') == 1){
      $output = '';
      $url = 'https://ipapi.co/'. $add .'/json/';
      $proc = json_decode(file_get_contents($url), true);

      if(!array_key_exists('error', $proc)){
        $output = $output . "****************************\n";
        $output = $output . 'IP ADDRESS: ' . $add . "\n";
        $output = $output . "****************************\n";

        if(array_key_exists('reserved', $proc)){
          $output = "IP Address is reserved.".$command;
        }else{

          foreach($proc as $key => $value) {
            $output = $output . ucfirst($key) . ': '. $value . "\n";
          }

          $output = $output . "\n";

        }
      }else{
        $output = ( array_key_exists('reason', $proc) ? $proc['reason'] : 'Error.');
      }




    }else{
      $output = "IP address is using invalid characters.".$command;
    }
  }else{
    $output = "Please input IP Address.".$command;
  }



  
  $answer = ['text' => $output];
  return $answer;
}