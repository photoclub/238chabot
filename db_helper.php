<?php
// SCHEMA
// sessions: id, user_id, recent_command, message, context, when
// Doc Reference: http://lessql.net/api

require_once 'vendor/autoload.php';

$db = new LessQL\Database(new PDO('sqlite:cquatro.sqlite3'));

function save_session_data($user_id, $command, $message, $context) {
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
        "context" => json_encode($message)
    ));
    $row->save();
    return $row;
}


function get_user_data($user_id) {
    global $db;
    $query = $db->sessions()
                ->where('user_id', $user_id);
    return json_encode($query);
}

// print_r(get_user_data('1234'));
// save_session_data("12345", "gender", "gender sherlock", "{'what': 'is this'}");
