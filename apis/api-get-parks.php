<?php

header('Content-Type: application/json');

$url = 'https://api.themeparks.wiki/v1/destinations';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    http_response_code(502);
    echo json_encode(['error' => 'Failed to fetch parks']);
    exit;
}

$data = json_decode($response, true);

echo json_encode($data);
