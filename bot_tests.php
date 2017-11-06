<?php


function getSlider($sender){
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

  return $jsonData;
}


