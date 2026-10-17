<?php
require_once 'config.php';

$message = "Hello, I need help with flowers for a graduation.";
$apiKey = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : '';

if (empty($apiKey)) {
    die("API Key not found in config.php\n");
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=" . $apiKey;

$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $message]
            ]
        ]
    ]
];

echo "Connecting to: " . $url . "\n\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "Curl Error: " . $error . "\n";
echo "Response: \n" . $response . "\n";
?>
