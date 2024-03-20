<?php

// Set your Telegram bot token
$botToken = '6716014110:AAFT8PcPe4LE2UI2wh6kXh2F6y208rjReWY';

// Set the URL for Telegram API
$apiUrl = 't.me/ChatFBY_bot' . $botToken . '/';

// Get updates from Telegram
$update = json_decode(file_get_contents('php://input'), true);

// Get the chat ID and message text
$chatId = $update['message']['chat']['id'];
$userMessage = $update['message']['text'];

// Define responses based on different messages in Farsi
$responses = array(
    "سلام" => "سلام!",
    "خوبی؟" => "من فقط یک ربات هستم!",
    "نامت چیه؟" => "من فقط یک چت‌بات هستم.",
    "خداحافظ" => "خداحافظ! روز خوبی داشته باشید!",
    "default" => "متوجه نشدم."
);

// Function to find the most similar response to the user message
function findMostSimilarResponse($userMessage, $responses) {
    $maxSimilarity = -1;
    $bestResponse = null;

    foreach ($responses as $pattern => $response) {
        similar_text(mb_strtolower($userMessage, 'UTF-8'), mb_strtolower($pattern, 'UTF-8'), $similarity);

        if ($similarity > $maxSimilarity) {
            $maxSimilarity = $similarity;
            $bestResponse = $response;
        }
    }

    return $bestResponse;
}

// Find the most similar response to the user message
$botResponse = findMostSimilarResponse($userMessage, $responses);

// Send the response back to the user
sendMessage($chatId, $botResponse);

// Function to send a message via Telegram API
function sendMessage($chatId, $message) {
    global $apiUrl;
    $url = $apiUrl . 'sendMessage?chat_id=' . $chatId . '&text=' . urlencode($message);
    file_get_contents($url);
}
