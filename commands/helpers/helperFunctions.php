<?php


function checkValidity($buffer,$type)
{
  switch ($type) {
    case 'name':
      return !preg_match('/[^A-Za-z\-\ ]/', $buffer);
    case 'date':
      return !preg_match('/[^0-9\-\/\ ]/', $buffer);
    case 'ip':
      return !preg_match('/[^0-9\.]/', $buffer);
    case 'phone':
      return !preg_match('/[^0-9\+\-\ ]/', $buffer);
    case 'currency':
      return !preg_match('/[^A-Za-z\,\ ]/', $buffer);
    case 'word':
      return !preg_match('/[^A-Za-z\-\/'\ ]/', $buffer);
    default:
      return 0;
  }
}


function getCommandList(){
  $output = "****************************\n";
  $output = $output . "HELP COMMANDS \n";
  $output = $output . "****************************\n";
  $output = $output . "• HELP\n";
  $output = $output . "• ECHO <your message>\n";
  $output = $output . "• GENDER <name>\n";
  $output = $output . "• HISTORY <mm/dd>\n";
  $output = $output . "  for a random trivia\n  leave date blank\n";
  $output = $output . "• POKEDEX <pokemon>\n";
  $output = $output . "• IP <ip address>\n";
  $output = $output . "• PHONE <phone number>\n";
  $output = $output . "• PHP <currency>\n";
  $output = $output . "• UNIVERSITY <name>\n";
  $output = $output . "• RECIPE <viand>\n";
  $output = $output . "• IMDB <movie title>\n";
  $output = $output . "• SYNONYMS <word>\n";
  return $output;
}

