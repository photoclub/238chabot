<?php

/* Required to setup bot to FB application messenger */
  $access_token = ‘your access token’;
  $verify_token = ‘your verify token’;

  if(isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe') {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];

    if ($hub_verify_token === $verify_token) {
      header("HTTP/1.1 200 OK");
      echo $challenge;
      die;
    }
  }
/* Required to setup bot to FB application messenger */

?>