<?php
// parameters
$hubVerifyToken = 'TOKEN123456abcd';
$accessToken = "EAAaDnngeMd0BAC4Va44xGlni3v2CpaiSZAHVEZBcSZA9VOjZAp2f2C3XqxZCAcRxDBwqZBE7ZAz4nOurtx9OJRft3zZBBbKSbUzwYYzZCRgbzy1ZBDI7zGw0PZBZCRmPW4tpFGcSNnxVfWUJ81tkyhKyJ7BNjODjMG4lsSENvJZCnmSq0KgZDZD";
// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
if(!empty($messageText))
{
	$answer = "알아 들을수 없어요 가능한 명령: 'hi' 'who' 'day' ";
	
	if($messageText == "hi") {
	    $answer = "안녕";
	}
	
	if($messageText == "who") {
	    $answer = "junho 님이 만드신 챗봇이에요";
	}
	
    if($messageText == "day") {
	    $answer = date("Y-m-d");
	}
	
	if($messageText == "아지야") {
	    $answer = "멍멍!";
	}
	
	if($messageText == "뭐해") {
		$answer = "밥먹고있어요.";
	}
	
	
	$response = [
	    'recipient' => [ 'id' => $senderId ],
	    'message' => [ 'text' => $answer ]
	];
	
	$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
    
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_exec($ch);
	curl_close($ch);
}