<?php
  
function getWeather($loc) {
  $command = " Please try again.\nWEATHER <location>";
  $keyword = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $loc)));

  if(!empty($loc)){
    if(checkValidity($loc, 'weather') == 1){
      $output = '';
      $url = "http://api.openweathermap.org/data/2.5/weather?q=".urlencode($loc)."&appid=d1ba467f884e7f259b64990372b464cd";
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc['weather'])){
        $output = "****************************\n";
        $output = $output . "WEATHER CONDITIONS\n" . strtoupper($loc) . " ";
        $output = $output . '(' . $proc['sys']['country'] . ')' . "\n";
        $output = $output . strtoupper($proc['weather'][0]['main']) . "\n";
        $output = $output . "****************************\n";

        $output = $output . ucfirst($proc['weather'][0]['description']) .". With ";
        $output = $output . 'average temperature of '.k_to_c($proc['main']['temp']).'C. ' ;
        $output = $output . 'Winds of '. $proc['wind']['speed'].'km/h and ';
        $output = $output . 'Humidity at '. $proc['main']['humidity'].'%.';


      }else{
        $output = "Location not found.".$command;
      }
    }else{
      $output = "Location name is using invalid characters.".$command;
    }
  }else{
    $output = "Please input location name.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

function k_to_c($temp) {
  if ( !is_numeric($temp) ) { return false; }
  return round(($temp - 273.15));
}
