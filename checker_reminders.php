<?php
include 'db_helper.php';
date_default_timezone_set('Asia/Manila');
//PXMAI
//$accessToken = 'EAAEkfXodrH4BAMyNIzcOwJMNfhsHMUyZBpntgSlWfB2d3nwg2lDwo4EYFnq633T64xGZBlrfQvHYZAaaqCqZCcmzaX1YnKZAUHuZCezfUrPa1hLzbo1LZBFSipZCgk3W9LAI9oUtPuwSOlYR56E3fcUKLGR5o2M2tpFmnS8nBBh06gZDZD';

//QUATTRO
$accessToken = 'EAABxniO6VYQBANVKSOirZB6pT7FHp2LGetRostBNQFZBn9yeY2ct2rrqtZAqqQcNPK0kJa014LmXyv7sP5Vk2K2jYs3Bn39fYwaEDp8hyIwxMwK2CVOQ6B2Qz37wFZAD1ctugY2NdZBkTSfA4roBToXVqZAN2KFWdxnLbttHcd1wZDZD';




$reminders = json_decode(json_encode(getRemindersToSend()), true);
print_r($reminders);

if ($reminders){
  $now = strtotime(date("Y-m-d H:i"));
  

  for($x=0; $x<count($reminders); $x++){
    $remind_date = strtotime(Date('Y-m-d H:i', strtotime($reminders[$x]['remind_date'])));
    $time_diff = $remind_date - $now;

    echo $remind_date ." ". $now . '<br><br>';
    echo $remind_date - $now . '<br><br>';


    if($time_diff <= 60 ){
      $output = "****************************\n";
      $output = $output . "REMINDER\n";
      $output = $output . Date('F j, Y H:i', strtotime($reminders[$x]['remind_date'])) . "\n";
      $output = $output . "****************************\n\n";
      $output = $output . ucfirst($reminders[$x]['message']);

      $message_to_reply = $output;
      
      /* Required code to communicate back to Facebook */
        $url = "https://graph.facebook.com/v2.6/me/messages?access_token=".$accessToken;
        $jsonData=formatToJsonText($reminders[$x]['user_id'],$message_to_reply);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
      /* Required code to communicate back to Facebook */


      markAsDone($reminders[$x]['user_id'],$reminders[$x]['remind_id']);
    }else{
      echo "no". '<br><br>';
    }
  }


  //if($reminders->remind_date)
  //now.getTime() - previous.getTime() >= 20*60*1000
}


$reminders = json_decode(json_encode(getRemindersOfUser('1527806963993871')), true);

if ($reminders){

  for($x=0; $x<count($reminders); $x++){
    
    $remind_date = Date('F jS, Y H:i', strtotime($reminders[$x]['remind_date']));
    $output = $reminders;

    echo "weee";

  }
}else{
  echo "waray";
}





function formatToJsonText($sender, $message){
  $jsonData=[
    'recipient' => [ 'id' => $sender ],
    'message' => [ 'text' => $message ]
  ];
  return json_encode($jsonData);
}
