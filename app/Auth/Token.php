<?php


namespace App\Auth;

use DomainException;
use Firebase\JWT\JWT;

final class Token
{
    /**
     * Expiry time of token
     * Default = 24 * 60 * 60
     * @var int $expiryTime
     */
    private static int $expiryTime = 8640;

    public static function encode(array $user): string
    {
        $user['expiry'] = time() + self::$expiryTime;
        return JWT::encode($user, env('APP_KEY'));
    }

    /**
     * @param string $jwtKey
     * @return array|false
     */
    public static function decode(string $jwtKey)
    {
        try {
            $decodedToken = (array)JWT::decode(
                $jwtKey,
                env('APP_KEY'),
                ['HS256']
            );
        } catch (DomainException $domainException) {
            return false;
        }

        if (array_key_exists('expiry', $decodedToken)) {
            if ($decodedToken['expiry'] > time()) {
                unset($decodedToken['expiry']);
                return $decodedToken;
            }
        }

        return false;
    }
}