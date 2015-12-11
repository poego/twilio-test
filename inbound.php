<?php
require_once __DIR__.'/vendor/autoload.php';

$xml = new Services_Twilio_Twiml();

if (empty($_POST['Digits'])) {
  $digit = null;
} else {
  $digit = (integer)$_POST['Digits'];
}

if ($digit == 1) {
  $xml->say('1を押しました。', array('language' => 'ja-jp'));
} else {
  $xml->say('こんにちは！1 を押して下さい。', array('language' => 'ja-jp'));
}

$xml->gather(array('numDigits' => 1, 'timeout' => 30));

header('Content-type: text/xml; charset=utf-8');
echo $xml;
