<?php

date_default_timezone_set('Asia/Manila');


function setReminder($message, $extra_context) {
  $command = " Please try again.\nREMIND <message> ~ <yyyy/mm/dd hh:mm>";
  $message = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $message)));
  $message = explode('~',$message);

  if(!empty($message)){
    if(checkValidity($message, 'reminders') == 1){
      
      if(strtotime($message[1])){

        $edate = explode(' ',trim($message[1]));

        if(isRemDate($edate[0]) && isRemTime($edate[1])){
          $remind_date = Date('Y-m-d H:i:s', strtotime($message[1]));
          $today = date("Y-m-d H:i:s");
          if ($today < $remind_date) {
            /* Saving Reminder */
              /* Check if existing reminders are set */
                $existing = getExistingReminderData($extra_context["user_id"]);
                if ($existing) {
                  $remind_id = intval($existing->remind_id) + 1;
                }else{
                  $remind_id = 1;
                }
              /* Check if existing reminders are set */

              saveReminderData($extra_context['user_id'], $remind_id , $message[0] , $remind_date );
              $output = 'Your reminder has been set.';


            /* Saving Reminder */
          }else{
            $output = 'Date cannot be past.' . $command;
          }
        }else{
           $output = 'Not valid format.' . $command;
        }
      }else{
        $output = 'Command format not valid.' . $command;
      }
    }else{
      $output = "Reminder is using invalid characters.".$command;
    }
  }else{
    $output = "Please set the reminder message and date.".$command;
  }

  $answer = ['text' => $output];
  return $answer;
}


function getReminder($message=NULL, $user) {
  if(!empty($message)){
    $output = 'mayds';
  }else{
    $reminders = json_decode(json_encode(getRemindersOfUser($user['user_id'])), true);

    if ($reminders){
      $remcount = count($reminders);
      $output = '';
      $output = $output . "****************************\n";
      $output = $output . $remcount . " REMINDER" . ($remcount > 1 ? 'S ' : ' '). ":\n";
      $output = $output . "****************************\n";
      for($x=0; $x < $remcount; $x++){
        $remind_date = Date('F j, Y H:i', strtotime($reminders[$x]['remind_date']));

        //$output = $output . '#' . $reminders[$x]['remind_id'] . "\n";
        $output = $output . $remind_date . "\n";
        $output = $output . $reminders[$x]['message'] . "\n\n";

      }
    }else{
      $output = "No reminders yet. Want to create one?\nREMIND <message> ~ <yyyy/mm/dd hh:mm>";
    }
  }

  $answer = ['text' => $output];
  return $answer;
}

function isRemDate($date) {
  if (preg_match("/^((((19|[2-9]\d)\d{2})\/(0[13578]|1[02])\/(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\/(0[13456789]|1[012])\/(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\/02\/(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\/02\/29))$/",$date)){
    return true;
  }else{
    return false;
  }
}


function isRemTime($time) {
  if (preg_match('/^\d{2}:\d{2}$/', $time)) {
      if (preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $time)) {
          return true;
      }else{
        return false;
      }
  }
}
