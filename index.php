<?php

$mainChannelId = getenv('CHANNEL_ID');
$hookUri = getenv('API_ENDPOINT');
$securityToken = getenv('SLACK_TOKEN');

$input = file_get_contents("php://input");
$body = json_decode($input, true);

if (isset($body["challenge"])) die($body["challenge"]);

if ($body["event"]["channel"] !== $mainChannelId) die;

if ($body["token"] !== $securityToken) die;

$text = "

Hallo <@{$body["event"]["user"]}>, goed dat je er bent!
";

$text .= file_get_contents("start_hier.txt");

$fields = ['text' => $text];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $hookUri);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
curl_exec($ch);

