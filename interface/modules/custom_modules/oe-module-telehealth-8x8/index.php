<?php
    declare(strict_types=1);


/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

    namespace Juggernaut\Modules;

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    require 'vendor/autoload.php';

    use DateTimeImmutable;
    use Lcobucci\JWT\Builder;
    use Lcobucci\JWT\JwtFacade;
    use Lcobucci\JWT\Signer\Hmac\Sha256;
    use Lcobucci\JWT\Signer\Key\InMemory;

    use function var_dump;
    $key = InMemory::base64Encoded(
        'hiG8DlOKvtih6AxlZn5XKImZ06yu8I3mkOzaJrEuW8yAv8Jnkw330uMt8AEqQ5LB'
    );

    $token = (new JwtFacade())->issue(
        new Sha256(),
        $key,
        static fn (
            Builder $builder,
            DateTimeImmutable $issuedAt
        ): Builder => $builder
            ->issuedBy('https://api.my-awesome-app.io')
            ->permittedFor('https://client-app.io')
            ->expiresAt($issuedAt->modify('+10 minutes'))
    );

    var_dump($token->claims()->all());
    echo $token->toString();
