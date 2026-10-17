<?php
require_once 'config.php';
$apiKey = GEMINI_API_KEY;
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if (isset($data['models'])) {
    foreach ($data['models'] as $model) {
        if (strpos($model['name'], 'gemini') !== false && in_array('generateContent', $model['supportedGenerationMethods'])) {
            echo "Model: " . $model['name'] . " (v" . $model['version'] . ")\n";
        }
    }
} else {
    echo "Error: " . $response;
}
?>
