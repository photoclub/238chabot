<?php

include 'bot_tokens.php';
include 'bot_charlotte_functions.php';

/* Processing the Chat message */
  $input = json_decode(file_get_contents('php://input'), true); // Get the chat
  $sender = $input['entry'][0]['messaging'][0]['sender']['id']; // User Scope ID of sender
  $message = isset($input['entry'][0]['messaging'][0]['message']['text']) ? $input['entry'][0]['messaging'][0]['message']['text']: '' ;  // Get Message text if available
  $jsonData = null;
/* Processing the Chat message */


if($message){

  $command = explode(' ',$message);
  $command = strtolower(array_shift($command));

  if($command=='echo'){
    //ECHO PARROT 
    $message_to_reply = strstr($message," ");
  }
  elseif($command=='gender'){
    //GENDER <name> Get probability of a name being a male or female name. https://genderize.io
    $g_name = trim(strstr($message," "));
    if (!empty($g_name)){
      $message_to_reply = getGender($g_name);
    }else{
      $message_to_reply = "Please input name. GENDER <name>";
    }
  }
  elseif($command=='history'){
    // HISTORY [optional date] Get today in history. http://numbersapi.com/
    $h_date = trim(strstr($message," "));
    $message_to_reply = getHistoryDate($h_date);
  }else{
    $message_to_reply = getCommandList();
  }


  /* Required code to communicate back to Facebook */
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=".$access_token;
    $jsonData=[
                'recipient' => [ 'id' => $sender ],
                'message' => [ 'text' => $message_to_reply ]
              ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);
  /* Required code to communicate back to Facebook */
}


function getCommandList(){
return "----------
Welcome to Quattro Chatbot!
----------
Commands
• ECHO <your message>
• GENDER <name>
• HISTORY <MM/DD>
   for a random trivia
   leave date blank
";
}


?>

