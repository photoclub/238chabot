<?php

/* Required to setup bot to FB application messenger */
  $access_token = 'EAABxniO6VYQBANVKSOirZB6pT7FHp2LGetRostBNQFZBn9yeY2ct2rrqtZAqqQcNPK0kJa014LmXyv7sP5Vk2K2jYs3Bn39fYwaEDp8hyIwxMwK2CVOQ6B2Qz37wFZAD1ctugY2NdZBkTSfA4roBToXVqZAN2KFWdxnLbttHcd1wZDZD';
  $verify_token = 'mastermaimai';

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