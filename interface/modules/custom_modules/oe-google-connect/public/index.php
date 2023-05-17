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

require_once "../vendor/autoload.php";

$client = new Google\Client();
$client->setApplicationName("OE-Clinic-Connection");


if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    var_dump($_SESSION['access_token']);
} else {
    $callForToken = "oauth2callback.php";
    header('Location: ' . filter_var($callForToken, FILTER_SANITIZE_URL));
}

$service = new Google\Service\Fitness($client);



