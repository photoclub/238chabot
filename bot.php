<?php
include 'FbBot.php';

$hubVerifyToken = 'mastermaimai';
$accessToken = 'EAABxniO6VYQBANVKSOirZB6pT7FHp2LGetRostBNQFZBn9yeY2ct2rrqtZAqqQcNPK0kJa014LmXyv7sP5Vk2K2jYs3Bn39fYwaEDp8hyIwxMwK2CVOQ6B2Qz37wFZAD1ctugY2NdZBkTSfA4roBToXVqZAN2KFWdxnLbttHcd1wZDZD';

$bot = new FbBot();
$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);

$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);


$uni ='university of the philippines';
$xxx = 'http://universities.hipolabs.com/search?name='. urlencode($uni);
$ttt = json_decode(file_get_contents($xxx), true);

if(!empty($ttt)){
$output = '';
$output = $output . "****************************\n";
$output = $output . "UNIVERSITY:\n" . ucwords($uni) . "\n";
$output = $output . "****************************\n";

	for($x = 0; $x < count($ttt); $x++ ){
	  $output = $output . "Name: " . $ttt[$x]['name'] . "\nCountry: ". $ttt[$x]['country'] . "\nWeb Pages: ". $ttt[$x]['web_pages'][0] . "\n";
	}
}

echo $output;