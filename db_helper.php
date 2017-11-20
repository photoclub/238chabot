<?php
// SCHEMA
// sessions: id, user_id, recent_command, message, context, when
// Doc Reference: http://lessql.net/api

require_once 'vendor/autoload.php';

$db = new LessQL\Database(new PDO('sqlite:cquatro.sqlite3'));

function saveSessionData($user_id, $command, $message, $context) {
    global $db;
    $row = $db->sessions()
              ->where('user_id', $user_id)
              ->fetch();
    if (!$row) {
        $row = $db->sessions()->createRow($properties = array());
    }
    $row->setData(array(
        "user_id" => $user_id,
        "recent_command" => $command,
        "message" => $message,
        "context" => json_encode($context)
    ));
    $row->save();
    return $row;
}


function getUserData($user_id) {
    global $db;
    $query = $db->sessions()
                ->where('user_id', $user_id)
                ->fetch();
    return $query;
}

function getUserDataForCommand($user_id, $command) {
    global $db;
    $query = $db->sessions()
                ->where('user_id', $user_id)
                ->where('recent_command', $command)
                ->fetch();
    return $query;
}

// CHARLOTTE REMINDERS
function saveReminderData($user_id, $remind_id, $message, $remind_date) {
    global $db;
    $row = $db->reminders()->createRow($properties = array());
    $row->setData(array(
        "user_id" => $user_id,
        "remind_id" => $remind_id,
        "message" => $message,
        "remind_date" => $remind_date,
        "done" => 0,    
        "when" => date("Y-m-d H:i:s"),
    ));
    $row->save();
    return $row; 
}

function getExistingReminderData($user_id) {
    global $db;
    $query = $db->reminders()
                ->where('user_id', $user_id)
                ->orderBy( 'when', 'DESC' )
                ->limit( 1 )
                ->fetch();
    return $query;
}

function getRemindersToSend() {
    global $db;
    $query = $db->reminders()
                ->where('done', 0)
                ->fetchAll();
    return $query;
}

function getRemindersOfUser($user_id) {
    global $db;
    $query = $db->reminders()
                ->where('user_id', $user_id)
                ->where('done', 0)
                ->fetchAll();
    return $query;
}

function markAsDone($user_id, $remind_id) {
    global $db;
    $row = $db->reminders()
                ->where('user_id', $user_id)
                ->where('remind_id', $remind_id)
                ->limit( 1 )
                ->fetch();

    $row->setData(array(
        "done" => 1   
    ));
    $row->save();
    return $row; 
}




// Usage:
// returns the LessQL object
// print_r(getUserData('1234'));
// $session_data = saveSessionData("12345", "gender", "gender sherlock", "{'what': 'is this'}");
// to access
// print_r($session_data['recent_command']);
// Display readable json format
// $something = getUserDataForCommand('1234', 'recipe');
// if ($something) {
//     print_r(json_encode($something));
// }
