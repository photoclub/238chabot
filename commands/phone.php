<?php

function getPhone($num) {
  $command = " Please try again.\nPHONE <phone number>";
  $num = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $num)));

  if(!empty($num)){
    if(checkValidity($num, 'phone') == 1){
      $output = '';
      $num = str_replace(array('+', '-'), '' , $num);
      $url = 'http://apilayer.net/api/validate?access_key=2ac4a493788c736a4adb8d8b5a4c3876&number=' . $num . '&country_code=&format=1';
      $proc = json_decode(file_get_contents($url), true);

      if($proc['valid']==true){

        $toDisplay = $proc;
        foreach ($toDisplay as $index => $data) {
            if ($data['index'] == 'valid' || $data['value'] == '') {
                unset($toDisplay[$index]);
            }
        }

        $output = $output . "****************************\n";
        $output = $output . 'PHONE: ' . $num . "\n";
        $output = $output . "****************************\n";



        foreach($toDisplay as $key => $value) {
          $output = $output . str_replace("_", " ", ucfirst($key)) . ': '. $value . "\n";
        }
      }else{
        $output = "Phone Number is not valid.".$command;
      }

      

    }else{
      $output = "Phone Number is using invalid characters.".$command;
    }
  }else{
    $output = "Please input Phone Number.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

