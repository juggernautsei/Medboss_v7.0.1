<?php
/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

namespace Juggernaut\Modules;

    class CreateJavaWebToken
    {
        private function buildHeader()
        {
            return json_encode(
                [
                    "alg" => "RS256",
                    "kid" => "vpaas-magic-cookie-1fc542a3e4414a44b2611668195e2bfe/4f4910",
                    "typ" => "JWT"
                ]
            );
        }

        private function buildPayload($name, $email, $moderator = true)
        {
            return json_encode(
                [
                      "aud" =>"jitsi",
                      "context" => [
                                "user" => [
                                      "id" => "0f8b7760-c17f-4a12-b134-c6ac37167144",
                                      "name" => $name,
                                      "avatar" => "",
                                      "email" => $email,
                                      "moderator" => $moderator
                                ],
                        "features" => [
                                      "livestreaming" => "false",
                                      "outbound-call" => "false",
                                      "transcription" => "false",
                                      "recording" => "false"
                                ],
                        "room" => [
                                    "regex" => false
                                ]
                      ],
                      "exp" => 1696284052,
                      "iss" => "chat",
                      "nbf" => 1596197652,
                      "room" => "*",
                      "sub" => "vpaas-magic-cookie-1fc542a3e4414a44b2611668195e2bfe"
                ]
            );
        }
    }
