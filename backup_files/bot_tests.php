<?php


function getSlider($sender){
/*
  $items = array();

  for($i=0;$i<5;$i++){
    $items[] = array(
      'title'=>"Title ".$i,
      'item_url'=>"https://hmpft.com",
      'image_url'=>"https://hmpft.com/wp-content/uploads/2017/10/sinulog_preview.jpg",
      'subtitle'=>"this is subtitle",
      'buttons'=>array(
        array(
          'type'=>"web_url",
          'url'=>"https://hmpft.com",
          'title'=>"hmpft button"
        ),
        array(
          'type'=>"postback",
          'payload'=>"salamat pag click",
          'title'=>"buttones"
        )
      ),
    );
  }

  $itemJson = json_encode($items);
  $output = '{
                "attachment":{
                  "type":"template",
                  "payload":{
                      "template_type":"generic",
                      "elements":'.$itemJson.
                  '}
                }
              }';

  $jsonData = '{"recipient":{"id":"'.$sender.'"},
        "message":'.$output.'
        }';
*/

  $answer = [
  "attachment" => [
  "type" => "template", 
  "payload" => [
  "template_type" => "generic", 
  "elements" => [[
  "title" => "Migrate your symfony application", 
  "item_url" => "https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/", 
  "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg", 
  "subtitle" => "Migrate your symfony application from Cpanel to Cloud.", 
  "buttons" => [[
  "type" => "web_url", 
  "url" => "www.cloudways.com", 
  "title" => "View Website"], 
  ["type" => "postback", 
  "title" => "Start Chatting", 
  "payload" => "get started"]]
  ]]
  ]]];

  $jsonData=formatText($sender,$answer);

  return $jsonData;
}


