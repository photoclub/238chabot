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
      return !preg_match('/[^A-Za-z\-\ ]/', $buffer);
    case 'weather':
      return !preg_match('/[^A-Za-z\-\,\ ]/', $buffer);
    case 'reminders':
      return !preg_match('/[^A-Za-z0-9\-\,\/\~\:\ ]/', $buffer);
    default:
      return 0;
  }
}


function getCommandList($comm = NULL){
  $comm = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $comm)));
  $comm = str_replace(array('/','-'),' ', $comm);

  if(empty($comm)){
    $output = "****************************\n";
    $output = $output . "HELP COMMANDS \n";
    $output = $output . "****************************\n";
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
    $output = $output . "• TRUMP <keyword>\n";
    $output = $output . "• WEATHER <location>\n";
    $output = $output . "• REMINDERS\n";
    $output = $output . "• REMIND <message> ~ \n <yyyy-mm-dd hh:mm>\n";
    $output = $output . "• HELP <command>\n";
    $output = $output . "  learn more about\n  the specific command\n";
  }else{

    $output = "****************************\n";
    $output = $output . "HELP INFO\n";
    $output = $output . strtoupper($comm) . "\n";
    $output = $output . "****************************\n";

    switch ($comm) {
      case 'echo':
        $output = $output . "Echoes back what you said in chat.\n\n";
        $output = $output . "Usage:\nECHO <your message>\n";
        $output = $output . "Example:\nECHO Hello World!\n";
        break;
      case 'imdb':
        $output = $output . "Displays requested movie details. Shows multiple results. Click on the View more reviews button for next page of results.\n\n";
        $output = $output . "Usage:\nIMDB <movie title>\n";
        $output = $output . "Example:\nIMDB Batman\n";
        break;
      case 'weather':
        $output = $output . "Returns selected location's weather condition.\n\n";
        $output = $output . "Usage:\nWEATHER <location>\n";
        $output = $output . "Example:\nWEATHER Tokyo\n";
        break;
      case 'phone':
        $output = $output . "Returns phone number details such as Country, Country prefix, Country Code, Line Type.\n\n";
        $output = $output . "Usage:\nPHONE <phone number>\n";
        $output = $output . "Example:\nPHONE 639181234567\n";
        break;
      case 'gender':
        $output = $output . "Provides the probability of name’s gender in percentage. Can handle multiple names \n\n";
        $output = $output . "Usage:\nGENDER <name>\n";
        $output = $output . "Example:\nGENDER Charlie\n";
        $output = $output . "GENDER Charlotte Efren\n";
        break;
      case 'history':
        $output = $output . "Displays the history of selected date. If Date is not provided, Bot randomly selects a History trivia. \n\n";
        $output = $output . "Usage:\nHISTORY\nHISTORY <mm/dd>\nHISTORY<mm-dd>\nHISTORY<mm dd>\n";
        $output = $output . "Example:\nHISTORY 1-2\n";
        break;
      case 'pokedex':
        $output = $output . "Returns the stats and ability of selected pokemon.\n\n";
        $output = $output . "Usage:\nPOKEDEX <pokemon>\n";
        $output = $output . "Example:\nPOKEDEX Pikachu\n";
        break;
      case 'php':
        $output = $output . "Converts PHP to the selected currency.\n\n";
        $output = $output . "Usage:\nPHP <currency>\n";
        $output = $output . "Example:\nPHP JPY\n";
        break;
      case 'university':
        $output = $output . "Displays the website(s) of selected university.\n\n";
        $output = $output . "Usage:\nUNIVERSITY <name>\n";
        $output = $output . "Example:\nUNIVERSITY University of the Philippines\n";
        break;
      case 'trump':
        $output = $output . "Displays quotes from Trump based on selected keyword.\n\n";
        $output = $output . "Usage:\nTRUMP <keyword>\n";
        $output = $output . "Example:\nTRUMP loss\n";
        break;
      case 'ip':
        $output = $output . "Provides information about selected IP Address.\n\n";
        $output = $output . "Usage:\nIP <ip address>\n";
        $output = $output . "Example:\nIP 8.8.8.8\n";
        break;
      case 'recipe':
        $output = $output . "Provides viand’s recipe site link. Shows multiple results. Click on the View more recipes button for next page of results.\n\n";
        $output = $output . "Usage:\nRECIPE <viand>\n";
        $output = $output . "Example:\nRECIPE adobo\n";
        break;
      case 'synonyms':
        $output = $output . "Displays the synonyms of a selected word.\n\n";
        $output = $output . "Usage:\nSYNONYMS <word>\n";
        $output = $output . "Example:\nSYNONYMS win\n";
        break;
      case 'remind':
        $output = $output . "Creates a reminder with a desired message and date time. Format is strict\n\n";
        $output = $output . "Usage:\nREMIND <message> ~ <yyyy/mm/dd hh:mm>\n";
        $output = $output . "Example:\nREMIND Take Exam ~ 2017/11/26 16:00\n";
        break;
      case 'reminders':
        $output = $output . "Lists all active reminders.\n\n";
        $output = $output . "Usage:\nREMINDERS\n";
        break;
      default:
        $output = "Specific command not found. Type HELP to get the command list.";
        break;
    }
  }

  $answer = ['text' => $output];
  return $answer;
}

