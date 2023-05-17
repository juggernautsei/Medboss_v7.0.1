<?php
/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

namespace Juggernaut\Modules;

use Firebase\JWT\JWT;
    class JavaWebToken
    {
        /**
         * Change the variables below.
         */
        private $apiKey = "my api key";

        private string $appId = "my app id"; // Your AppID (previously tenant)
        private string $userEmail = "myemail@email.com";
        private string $userName = "my user name";
        private bool $userIsModorator = true;
        private string $userAvatarUrl = "";

        private string $userId = "my unique user id";
        private bool $livestreamingIsEnabled = true;
        private bool $recordingIsEnabled = true;
        private bool $outboundIsEnabled = false;
        private bool $transcriptionIsEnabled = false;
        private int $expDelaySec = 7200;
        private int $nbfDelaySec = 0;


// Read your private key from file see https://jaas.8x8.vc/#/apikeys
        private function getPrivateKey()
        {
            $keyLocation = dirname(__FILE__, 6) . "/sites/default/documents/logs_and_misc/";
            return file_get_contents($keyLocation . "/Key_3_18_2023_10_02_09_PM.pk");
        }


// Use the following function to generate your JaaS JWT.
        private function createJaasToken(
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
            $private_key
        ): string
        {
            $payload = array(
                'iss' => 'chat',
                'aud' => 'jitsi',
                'exp' => time() + $exp_delay,
                'nbf' => time() - $nbf_delay,
                'room'=> '*',
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

        public function genJavaWebToken()
        {
            $private_key = $this->getPrivateKey();
          return $this->createJaasToken(
              $this->apiKey,
              $this->appId,
              $this->userEmail,
              $this->userName,
              $this->userIsModorator,
              $this->userAvatarUrl,
              $this->userId,
              $this->livestreamingIsEnabled,
              $this->recordingIsEnabled,
              $this->outboundIsEnabled,
              $this->transcriptionIsEnabled,
              $this->expDelaySec,
              $this->nbfDelaySec,
              $private_key
          );
        }
    }
