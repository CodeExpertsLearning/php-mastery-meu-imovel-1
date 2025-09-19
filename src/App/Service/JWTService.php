<?php

namespace Code\App\Service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;

class JWTService
{
    public function criarToken(array $payload)
    {
        $key = InMemory::base64Encoded(JWT_KEY);

        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            static fn (Builder $builder, \DateTimeImmutable $data): Builder =>
            $builder
                ->issuedBy(HOME_URL)
                ->permittedFor(HOME_URL)
                ->withClaim('uid', $payload['id'])
                ->issuedAt($data)
                ->expiresAt($data->modify(JWT_EXPIRES_STR))
        );

        return $token->toString();
    }

    public function validarToken(string $token)
    {
        $parser = new Parser(new JoseEncoder);
        $token = $parser->parse($token);

        $validator = new Validator();

        return $validator->validate(
            $token,
            new SignedWith(new Sha256(), InMemory::base64Encoded(JWT_KEY))
        );
    }
}
