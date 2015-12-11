<?php
require_once __DIR__ . '/vendor/autoload.php';

$response = new Services_Twilio_Twiml();
$gather = $response->gather(array(
    'action' => 'http://czn3lqf-afp-app000.c4sa.net/process_poll.php',
    'method' => 'GET',
    'timeout' => '30',
    'numDigits' => '1'
));
$gather->say("これから投票を行います。1桁の作品番号を押してください。", array('language' => 'ja-jp'));
header("Content-type: text/xml");
print $response;