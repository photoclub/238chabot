<?php

function getSynonyms($word) {
  $command = " Please try again.\nSYNONYMS <word>";
  $word = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $word)));

  if(!empty($word)){
    if(checkValidity($word, 'name') == 1){
      $output = '';

      $url = 'http://api.wordnik.com:80/v4/word.json/'. $word .'/relatedWords?useCanonical=false&limitPerRelationshipType=10&api_key=a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5';
      $proc = json_decode(file_get_contents($url), true);

      if(!empty($proc)){
        if($proc[0]['relationshipType']!='unknown'){
          $output = $output . "****************************\n";
          $output = $output . "SYNONYMS:\n" . strtoupper($word) . "\n";
          $output = $output . "****************************\n";

          for($x=0; $x<count($proc); $x++){
            if($proc[$x]['relationshipType']=='synonym'){
              $synonyms = $proc[$x]['words'];
              for($y = 0; $y < count($synonyms); $y++){
                $output = $output . $synonyms[$y];
                if($y != (count($synonyms)-1)){
                  $output = $output .", ";
                }
              }
              break;
            }
          }
        }else{
          $output = "Synonyms for ". $word . " not found.".$command;
        }
      }else{
        $output = "Word not found.".$command;
      }

    }else{
      $output = "Word is using non-supported characters.".$command;
    }
  }else{
    $output = "Please input word.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}

