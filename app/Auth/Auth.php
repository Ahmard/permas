<?php


namespace App\Auth;


use App\Models\User;

final class Auth
{
    private static string $token = '';

    private ?User $user = null;

    private bool $isAuthenticated = false;


    public function __construct(string $token)
    {
        self::$token = $token;
    }

    /**
     * @param string $token
     * @return bool
     */
    public static function handle(string $token): bool
    {
        self::$token = $token;
        return (new self($token))->authenticateToken();
    }

    /**
     * @return bool
     */
    private function authenticateToken(): bool
    {
        if (self::$token) {
            $verified = Token::decode(self::$token);
            if ($verified) {
                $user = User::query()->find('username', $verified['id']);
                return !empty($user);
            }

            return false;
        }

        return false;
    }


    /**
     * Check if user is authenticated
     * @return bool
     */
    public function check(): bool
    {
        return $this->isAuthenticated;
    }

    public function userId(): ?int
    {
        return $this->user()['id'] ?? 1;
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * Get user token
     * @return string
     */
    public function token(): string
    {
        return self::$token;
    }
}