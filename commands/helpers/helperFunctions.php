<?php


function checkValidity($buffer,$type)
{
  switch ($type) {
    case 'name':
      return !preg_match('/[^A-Za-z\-\ ]/', $buffer);
    case 'date':
      return !preg_match('/[^0-9\-\/\ ]/', $buffer);
    default:
      return 0;
  }
}


function getCommandList(){
  $output = "****************************\n";
  $output = $output . "HELP COMMANDS \n";
  $output = $output . "****************************\n";
  $output = $output . "• ECHO <your message>\n";
  $output = $output . "• GENDER <name>\n";
  $output = $output . "• HISTORY <mm/dd>\n";
  $output = $output . "• POKEDEX <pokemon>\n";
  $output = $output . "  for a random trivia\n  leave date blank\n";
  return $output;
}
