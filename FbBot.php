<?php
require 'vendor/autoload.php';
include 'commands/recipe.php';
include 'commands/gender.php';
include 'commands/history.php';
include 'commands/pokemon.php';
include 'commands/ip.php';
include 'commands/phone.php';
include 'commands/php.php';
include 'commands/imdb.php';
include 'commands/helpers/helperFunctions.php';



use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FbBot
{
    private $hubVerifyToken = null;
    private $accessToken    = null;
    private $tokken         = false;
    protected $client       = null;

    public function __construct()
    {
        $this->imdb = new IMDB();
    }

    public function setHubVerifyToken($value)
    {
        $this->hubVerifyToken = $value;
    }

    public function setAccessToken($value)
    {
        $this->accessToken = $value;
    }

    public function verifyTokken($hub_verify_token, $challange)
    {
        try {
            if ($hub_verify_token === $this->hubVerifyToken) {
                return $challange;
            } else {
                throw new Exception("Tokken not verified");
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function readMessage($input)
    {
        try {
            $payloads    = null;
            $senderId    = $input['entry'][0]['messaging'][0]['sender']['id'];
            $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
            $postback    = $input['entry'][0]['messaging'][0]['postback'];
            $loctitle    = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['title'];
            if (!empty($postback)) {
                $payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
                return ['senderid' => $senderId, 'message' => $payloads];
            }

            if (!empty($loctitle)) {
                $payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
                return ['senderid' => $senderId, 'message' => $messageText, 'location' => $loctitle];
            }

            // var_dump($senderId,$messageText,$payload);
            //   $payload_txt = $input['entry'][0]['messaging'][0]['message']['quick_reply']‌​['payload'];

            return ['senderid' => $senderId, 'message' => $messageText];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function sendMessage($input)
    {
        try {
            $client      = new Client();
            $url         = "https://graph.facebook.com/v2.6/me/messages";
            $messageText = strtolower($input['message']);
            $senderId    = $input['senderid'];
            $msgarray    = explode(' ', $messageText);
            $response    = null;
            $answer = '';
            $header      = array(
                'content-type' => 'application/json',
            );
            if (in_array('hi', $msgarray)) {
                $answer = ['text' => "Hello! Welcome to Quattro Chatbot. For a list of commands type HELP"];
            } elseif ($msgarray[0] == 'recipe') {
                $answer = getRecipe(implode(" ", array_slice($msgarray, 1)), ['user_id' => $senderId]);
                file_put_contents('test-list-recipe.txt', json_encode($answer));
            } elseif ($msgarray[0] == 'help') {

                $answer = ['text' => getCommandList() ];

            } elseif ($msgarray[0] == 'echo') {
                $parrot = implode(" ", array_slice($msgarray, 1));
                if(!empty($parrot)){
                  $answer = ['text' => $parrot];
                }else{
                  $answer = ['text' => "There's nothing to echo. Please try again.\nECHO <your message>"];
                }
            } elseif ($msgarray[0] == 'gender') {
                $answer = getGender(implode(" ", array_slice($msgarray, 1)));
            } elseif ($msgarray[0] == 'history') {
                $answer = getHistory(implode(" ", array_slice($msgarray, 1)));
            } elseif ($msgarray[0] == 'pokedex') {
                $answer = getPokemon(implode(" ", array_slice($msgarray, 1)));
            } elseif ($msgarray[0] == 'ip') {
                $answer = getIP(implode(" ", array_slice($msgarray, 1)));
            } elseif ($msgarray[0] == 'phone') {
                $answer = getPhone(implode(" ", array_slice($msgarray, 1)));
            } elseif ($msgarray[0] == 'php') {
                $answer = getPhp(implode(" ", array_slice($msgarray, 1)));
            } elseif ($msgarray[0] == 'imdb') {
                $answer = $this->imdb->getMovieRating(implode(" ", array_slice($msgarray, 1)));
            } elseif (in_array('blog', $msgarray)) {
                $answer = [
                    "attachment" => [
                        "type"    => "template",
                        "payload" => [
                            "template_type" => "generic",
                            "elements"      => [[
                                "title"     => "Migrate your symfony application",
                                "item_url"  => "https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
                                "subtitle"  => "Migrate your symfony application from Cpanel to Cloud.",
                                "buttons"   => [[
                                    "type"  => "web_url",
                                    "url"   => "www.cloudways.com",
                                    "title" => "View Website"],
                                    ["type"   => "postback",
                                        "title"   => "Start Chatting",
                                        "payload" => "get started"]],
                            ]],
                ]]];
            } elseif (in_array('list', $msgarray)) {
                $answer = ["attachment" => [
                    "type"    => "template",
                    "payload" => [
                        "template_type" => "list",
                        "elements"      => [[
                            "title"     => "Welcome to Peter\'s Hats", "item_url" => "https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
                            "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
                            "subtitle"  => "We\'ve got the right hat for everyone.",
                            "buttons"   => [
                                [
                                    "type"  => "web_url", "url" => "https://cloudways.com",
                                    "title" => "View Website"],
                            ]],
                            [
                                "title"     => "Multipurpose Theme Design and Versatility",
                                "item_url"  => "https://www.cloudways.com/blog/multipurpose-wordpress-theme-for-agency/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/How-a-multipurpose-WordPress-theme-can-help-your-agency-Banner.jpg",
                                "subtitle"  => "We've got the right theme for everyone.",
                                "buttons"   => [
                                    [
                                        "type"  => "web_url",
                                        "url"   => "https://cloudways.com",
                                        "title" => "View Website",
                                    ]]],
                            [
                                "title"     => "Add Custom Discount in Magento 2",
                                "item_url"  => "https://www.cloudways.com/blog/add-custom-discount-magento-2/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/M2-Custom-Discount-Banner.jpg",
                                "subtitle"  => "Learn adding magento 2 custom discounts.",
                                "buttons"   => [
                                    [
                                        "type"  => "web_url",
                                        "url"   => "https://cloudways.com",
                                        "title" => "View Website"],
                                ]],
                        ]],
                ]];
                file_put_contents('list-list-list.txt', json_encode($answer));
            }
            // Keep for reference
            // elseif ($messageText == '') {
            //     $answer = [
            //         "text"          => "Please share your location:",
            //         "quick_replies" => [
            //             [
            //                 "content_type" => "location",
            //             ],
            //     ]];
            // } elseif (!empty($input['location'])) {
            //     $answer = ["text" => 'great you are at' . $input['location']];
            // }
            elseif (!empty($messageText)) {

                $answer = ['text' => 'command not found'];
            }

            $response = [
                'recipient' => ['id' => $senderId],
                'message' => $answer,
                'access_token' => $this->accessToken
            ];

            $response = $client->post($url, ['query' => $response, 'headers' => $header]);

            return true;
        } catch (RequestException $e) {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            file_put_contents("test.json", json_encode($response));
            return $response;
        }
    }
}

