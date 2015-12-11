<?php
require_once __DIR__ . '/vendor/autoload.php';

// Connect to MySQL, and connect to the Database
$pollDigits = $_REQUEST['Digits'];

$say_str="番の作品を選択しました。ありがとうございました。";
switch ($pollDigits) {
    case 1:
        $say = $pollDigits.$say_str;
        break;
    case 2:
        $say = $pollDigits.$say_str;
        break;
    case 3:
        $say = $pollDigits.$say_str;
        break;
    case 4:
        $say = $pollDigits.$say_str;
        break;
    case 5:
        $say = $pollDigits.$say_str;
        break;
    case 6:
        $say = $pollDigits.$say_str;
        break;
    default:
        $say = '投票可能な番号は1から6までです。番号を確認してください。';
        break;
}

$response = new Services_Twilio_Twiml();
$response->say($say, array('language' => 'ja-jp'));
$response->hangup();
header("Content-type: text/xml");
print $response;