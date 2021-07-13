<?php

namespace RedSocial\Models;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use RedSocial\Core\App;
use \DateTimeImmutable;

require_once __DIR__ . '/../../../../vendor/autoload.php';

class Token
{
    /**
     * Crea un token de JWT.
     *
     * @param int $id
     * @return string
     */
    public static function createToken(int $id): string
    {
        $key = App::getEnv('SECRET_KEY');
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded($key)
        );

        $builder = $config->builder();
        $token = $builder
            ->issuedBy('https://davinci.edu.ar')
            ->issuedAt(new DateTimeImmutable())
            ->withClaim('id', $id)
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }

    /**
     * Parsea el $token provisto como string, e informa de si es un token válido.
     * De serlo, retorna los datos pertinentes del token, como el id del usuario.
     *
     * @param string $token
     * @return array|bool
     */
    function parseAndVerifyToken(string $token)
    {
        $key = App::getEnv('SECRET_KEY');
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded($key)
        );

        $parsedToken = $config->parser()->parse($token);

        try {
            $constraints = [
                new SignedWith($config->signer(), $config->signingKey()),
                new IssuedBy('https://davinci.edu.ar'),
            ];

            $config->validator()->assert($parsedToken, ...$constraints);

            return [
                'id' => $parsedToken->claims()->get('id')
            ];
        } catch (\Exception $e) {
            return false;
        }
    }
}
