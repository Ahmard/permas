<?php


namespace App\Utils;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Auth
{
    protected User|Model|null $user;


    public function user(): User|Model|null
    {
        if (!isset($this->user)) {
            $this->user = User::query()->find(1);
        }

        return $this->user;
    }

    public function check(): bool
    {
        return null !== $this->user();
    }

    public static function makeHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyHash(string $password, string $hashed): bool
    {
        return password_verify($password, $hashed);
    }
}