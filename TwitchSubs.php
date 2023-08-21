<?php
// Replace with your Twitch API credentials
$client_id = 'YOUR_CLIENT_ID';
$client_secret = 'YOUR_CLIENT_SECRET';

// User ID of the channel you want to check (replace with your channel's user ID)
$channel_user_id = 'YOUR_CHANNEL_USER_ID';

// User ID of the user you want to check if they follow the channel
$user_to_check_id = 'USER_TO_CHECK_USER_ID';

// Get the OAuth token
$token_url = "https://id.twitch.tv/oauth2/token?client_id=$client_id&client_secret=$client_secret&grant_type=client_credentials";
$response = file_get_contents($token_url);
$data = json_decode($response, true);
$access_token = $data['access_token'];

// Check if the user follows the channel
$check_follow_url = "https://api.twitch.tv/helix/users/follows?from_id=$user_to_check_id&to_id=$channel_user_id";
$options = [
    'http' => [
        'header' => "Client-ID: $client_id\r\nAuthorization: Bearer $access_token\r\n",
    ],
];
$context = stream_context_create($options);
$response = file_get_contents($check_follow_url, false, $context);
$data = json_decode($response, true);

if (!empty($data['data'])) {
    echo "The user follows the channel.";
} else {
    echo "The user does not follow the channel.";
}
?>
