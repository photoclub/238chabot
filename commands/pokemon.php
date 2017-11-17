<?php

function getPokemon($pokemon) {
  $command = " Please try again.\nPOKEDEX <pokemon>";
  $pokemon = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $pokemon)));

  if(!empty($pokemon)){
    if(checkValidity($pokemon, 'name') == 1){
      $url = 'https://pokeapi.co/api/v2/pokemon/'.$pokemon;
      $proc = json_decode(file_get_contents($url), true);

      $pokename = $proc['name'];

      if(!empty($pokename)){
        $abilities = $proc['abilities'];
        $types = $proc['types'];
        $stats = $proc['stats'];

        $output = "****************************\n";
        $output = $output . "POKEDEX #" . $proc['id'] . "\n" . strtoupper($pokename) . "\n";
        $output = $output . "****************************\n";

        $output = $output . (!empty($proc['height']) ? "Height: " . $proc['height']. "\n" : '');
        $output = $output . (!empty($proc['weight']) ? "Weight: " . $proc['weight']. "\n" : '');

        if (!empty($types)){
          $c = count($types);
          $output = $output . 'Type' . ($c>1 ? "s" : '') . ": ";
          for($x=0; $x< $c; $x++){
            $output = $output . $types[$x]['type']['name'];
            if($x != ($c-1)){
              $output = $output .", ";
            }
          }
          $output = $output . "\n";
        }

        if (!empty($abilities)){
          $c = count($abilities);
          $output = $output . ($c>1 ? "Abilities" : 'Ability') . ": ";
          for($x=0; $x< $c; $x++){
            $output = $output . $abilities[$x]['ability']['name'];
            if($x != ($c-1)){
              $output = $output .", ";
            }
          }
          $output = $output . "\n";
        }

        if (!empty($stats)){
          $c = count($stats);
          $stats = array_reverse($stats);
          $output = $output . "--------------------------\nBASE STATS\n--------------------------\n";
          for($x=0; $x< $c; $x++){
            $output = $output . ucfirst($stats[$x]['stat']['name']) . ': ' . $stats[$x]['base_stat'];
            if($x != ($c-1)){
              $output = $output ."\n";
            }
          }
          $output = $output . "\n";
        }


      }else{
        $output = "Pokemon not found.".$command;
      }

    }else{
      $output = "Pokemon name is using invalid characters.".$command;
    }
  }else{
    $output = "Please input Pokemon's name.".$command;
  }
  
  $answer = ['text' => $output];
  return $answer;
}