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

    use Jose\Component\Core\AlgorithmManager;
    use Jose\Component\Core\JWK;
    use Jose\Component\Signature\Algorithm\RS256;
    use Jose\Component\Signature\JWSBuilder;
    use Jose\Component\KeyManagement\JWKFactory;

// The algorithm manager with the HS256 algorithm.
    $algorithmManager = new AlgorithmManager([
        new RS256(),
    ]);

// Our key.
    $keyFile = dirname(__FILE__, 6) . "/sites/RsaPrivateKey.pk";
    $contents = file_get_contents($keyFile);

    $jwk = JWKFactory::createFromKeyFile(
        $keyFile,
        '',
        [
         'use' => 'sig',
         ]
    );

// We instantiate our JWS Builder.
    $jwsBuilder = new JWSBuilder($algorithmManager);

    echo "No Errors";

    // The payload we want to sign. The payload MUST be a string hence we use our JSON Converter.
    $payload = json_encode([
        'iat' => time(),
        'nbf' => time(),
        'exp' => time() + 3600,
        'iss' => 'My service',
        'aud' => 'Your application',
    ]);

    $jws = $jwsBuilder
        ->create()                               // We want to create a new JWS
        ->withPayload($payload)                  // We set the payload
        ->addSignature($jwk, ['alg' => 'RS256']) // We add a signature with a simple protected header
        ->build();                               // We build it
