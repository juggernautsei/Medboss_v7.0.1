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

    $algorithmManager = new AlgorithmManager([
        new RS256(),
    ]);

    $keyFile = dirname(__FILE__, 6) . "/sites/RsaPrivateKey.pk";
    $contents = file_get_contents($keyFile);


    use Jose\Component\KeyManagement\JWKFactory;

    $key = JWKFactory::createFromKeyFile(
        $keyFile, // The filename
        null,                   // Secret if the key is encrypted, otherwise null
        [
            'use' => 'sig',         // Additional parameters
        ]
    );

    echo "done";
    $jwsBuilder = new JWSBuilder($algorithmManager);

    // The payload we want to sign. The payload MUST be a string hence we use our JSON Converter.
    $payload = json_encode([
        'exp' => time() + 3600,
        'iss' => 'My service',
        'aud' => 'jitsi',
    ]);


    $jws = $jwsBuilder
        ->create()                               // We want to create a new JWS
        ->withPayload($payload)                  // We set the payload
        ->addSignature($key, ['alg' => 'RS256']) // We add a signature with a simple protected header
        ->build();                               // We build it

    use Jose\Component\Signature\Serializer\CompactSerializer;

    $serializer = new CompactSerializer(); // The serializer

    $token = $serializer->serialize($jws, 0); // We serialize the signature at index 0 (we only have one signature).

    var_dump($token);
