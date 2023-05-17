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

//var_dump($_GET['code']);
require_once "../vendor/autoload.php";

use Juggernaut\Module\App\GoogleAuthSetParameters;
use Juggernaut\Module\App\GoogleAccessTokenAuthenticationStore;

$client = new Google\Client();
$authConfigJson = new GoogleAuthSetParameters($client);
$store = new GoogleAccessTokenAuthenticationStore();

if (! isset($_GET['code'])) {
    $authUrl = '';
    try {
        $authUrl = $authConfigJson->setAuthParameters();
    } catch (\Google\Exception $e) {
        error_log('Google params failed');
    }
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
} else {
    var_dump($_GET['code']);
    $jsonFileName = $authConfigJson::JSON_FILE_NAME;
    $jsonPath = $authConfigJson->jsonFilePath;
    $client->setAuthConfig($jsonPath.$jsonFileName);
    $access_token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $bindings = [
        'Fit',
        3, //$_SESSION['PID'],
        $access_token['access_token'],
        $access_token['refresh_token'],
        $access_token['expires_in'],
        $access_token['scope'],
        $access_token['token_type'],
        date('Y-m-d'),
    ];
    //if access token is returned then save it
    if ($access_token['access_token']) {
        $id = $store->storeAccessTokenAndRefresh($bindings);
    }
    //if data is saved do this
    if ($id) {
        var_dump($id);
    }

}
