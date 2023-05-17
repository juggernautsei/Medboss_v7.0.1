<?php
/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

namespace Juggernaut\Module\App;

    require_once "../vendor/autoload.php";
    $ignoreAuth = true;
    $sessionAllowWrite = true;
    require_once dirname(__DIR__, 5)  . "/globals.php";

    use Google\Client;
    use OpenEMR\Common\Crypto\CryptoGen;
    use Google\Exception;
    use OpenEMR\Common\Logging\SystemLogger;

    final class GoogleAuthSetParameters
    {
        const MODULE_INSTALLATION_PATH = "/interface/modules/custom_modules/";
        const MODULE_NAME = "oe-google-connect";
        const JSON_FILE_NAME = "client_id.json";
        public string $jsonFilePath;

        private CryptoGen $cryptoGen;

        private Client $client;

        public function __construct(
            Client $client
        )
        {
            $this->cryptoGen = new CryptoGen();
            $this->client = $client;
            $this->jsonFilePath = dirname(__DIR__, 6) . "/sites/" . $_SESSION['site_id'] . "/documents/logs_and_misc/";
        }

        public function redirectUri(): string
        {
            return 'https://' . $_SERVER['HTTP_HOST'] .
                self::MODULE_INSTALLATION_PATH .
                self::MODULE_NAME .
                '/public';
        }

        /**
         * @throws Exception
         */
        public function setAuthParameters()
        {
            $logger = new SystemLogger();
            $client_json = self::createGoogleJson();
            $file = self::JSON_FILE_NAME;

            if ($client_json) {
                $this->client->setAuthConfig($this->jsonFilePath.$file);
                $this->client->setRedirectUri(
                    'https://' . $_SERVER['HTTP_HOST'] .
                    self::MODULE_INSTALLATION_PATH .
                    self::MODULE_NAME .
                    '/public/oauth2callback.php'
                );
                $scopes = $this->googleScopes();
                $this->client->addScope($scopes);
                $this->client->setAccessType('offline');
                $this->client->setPrompt('consent');
                $this->client->setIncludeGrantedScopes(true); // incremental auth

                return $this->client->createAuthUrl();
            } else {
                //silently fail write to log
                $logger->error('Failed to create json file for auth check logs and misc folder permissions');
                die;
            }
        }

        private function createGoogleJson()
        {
            $uris = 'https://' .
                $_SERVER['HTTP_HOST'] .
                self::MODULE_INSTALLATION_PATH .
                self::MODULE_NAME .
                '/public/oauth2callback.php';
            $encryptedValue_client = $this->cryptoGen->decryptStandard($GLOBALS['oe_client_id_encrypted']);
            $encryptedValue_client_secret = $this->cryptoGen->decryptStandard($GLOBALS['oe_client_secret_encrypted']);
            $client_secret_json = [
                "web" => [
                    "client_id" => $encryptedValue_client,
                    "project_id" => "affordablecustomehr",
                    "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                    "token_uri" => "https://oauth2.googleapis.com/token",
                    "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                    "client_secret" => $encryptedValue_client_secret,
                    "redirect_uris" => [$uris]
                ]
            ];
            $file = self::JSON_FILE_NAME;
            $json = json_encode($client_secret_json);
            file_put_contents($this->jsonFilePath.$file, $json);
            if (file_exists($this->jsonFilePath.$file)) {
                return true;
            }
            return false;
        }

        private function googleScopes()
        {
            $scope = [];
            $scope[] = "https://www.googleapis.com/auth/fitness.activity.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.blood_glucose.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.blood_pressure.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.body.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.body_temperature.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.heart_rate.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.body_temperature.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.location.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.nutrition.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.oxygen_saturation.read";
            $scope[] = "https://www.googleapis.com/auth/fitness.sleep.read";

            return $scope;
        }
    }
