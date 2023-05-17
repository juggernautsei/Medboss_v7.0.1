<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */


require dirname(__FILE__, 2) . '/vendor/autoload.php';

use Firebase\JWT\JWT;

/**
 * Change the variables below.
 */
$API_KEY="vpaas-magic-cookie-02bc0019d5a3438186239dc1711e0ee1/fe45eb";
$APP_ID="vpaas-magic-cookie-02bc0019d5a3438186239dc1711e0ee1"; // Your AppID (previously tenant)
$USER_EMAIL="sherwingaddis@gmail.com";
$USER_NAME="Sherwin Gaddis";
$USER_IS_MODERATOR=true;
$USER_AVATAR_URL="";
$USER_ID="1711e0ee1/674ba7";
$LIVESTREAMING_IS_ENABLED=true;
$RECORDING_IS_ENABLED=true;
$OUTBOUND_IS_ENABLED=false;
$TRANSCRIPTION_IS_ENABLED=false;
$EXP_DELAY_SEC=7200;
$NBF_DELAY_SEC=0;
///

// Read your private key from file see https://jaas.8x8.vc/#/apikeys
//$private_key = file_get_contents("./rsa-private.pk");
$keyLocation = dirname(__FILE__, 6) . "/sites/jaasauth.key";
    $private_key = file_get_contents($keyLocation);

// Use the following function to generate your JaaS JWT.
function create_jaas_token(
    $api_key,
    $app_id,
    $user_email,
    $user_name,
    $user_is_moderator,
    $user_avatar_url,
    $user_id,
    $live_streaming_enabled,
    $recording_enabled,
    $outbound_enabled,
    $transcription_enabled,
    $exp_delay,
    $nbf_delay,
    $private_key) {

    $payload = array(
        'iss' => 'chat',
        'aud' => 'jitsi',
        'exp' => time() + $exp_delay,
        'nbf' => time() - $nbf_delay,
        'room'=> '626',
        'sub' => $app_id,
        'context' => [
            'user' => [
                'moderator' => $user_is_moderator ? "true" : "false",
                'email' => $user_email,
                'name' => $user_name,
                'avatar' => $user_avatar_url,
                'id' => $user_id
            ],
            'features' => [
                'recording' => $recording_enabled ? "true" : "false",
                'livestreaming' => $live_streaming_enabled ? "true" : "false",
                'transcription' => $transcription_enabled ? "true" : "false",
                'outbound-call' => $outbound_enabled ? "true" : "false"
            ]
        ]
    );
    return JWT::encode($payload, $private_key, "RS256", $api_key);
}

//
$token = create_jaas_token($API_KEY,
    $APP_ID,
    $USER_EMAIL,
    $USER_NAME,
    $USER_IS_MODERATOR,
    $USER_AVATAR_URL,
    $USER_ID,
    $LIVESTREAMING_IS_ENABLED,
    $RECORDING_IS_ENABLED,
    $OUTBOUND_IS_ENABLED,
    $TRANSCRIPTION_IS_ENABLED,
    $EXP_DELAY_SEC,
    $NBF_DELAY_SEC,
    $private_key);

/// This writes the jwt to standard output
echo $token;
