<?php
	
function getTrump($keyword) {
  $command = " Please try again.\nTRUMP <keyword>";
  $keyword = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $keyword)));

  if(!empty($keyword)){
    if(checkValidity($keyword, 'name') == 1){
      $output = '';
      $url = 'https://api.tronalddump.io/search/quote?query='.$keyword;
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc['count'] != 0)){
        $output = $output . "****************************\n";
        $output = $output . "TRUMP's\nQUOTE ABOUT \n" . strtoupper($keyword) . "\n";
        $output = $output . "****************************\n";
        $count = intval($proc['count']) - 1;
        $rand = rand(0, $count);
        $output = $output . $proc['_embedded']['quotes'][$rand]['value'];
      }else{
        $output = "Search keyword is not valid.".$command;
      }
    }else{
      $output = "Search keyword is using invalid characters.".$command;
    }
  }else{
    $output = "Please input a search keyword.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}