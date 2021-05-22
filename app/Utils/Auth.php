<?php


namespace App\Utils;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class Auth
{
    #[ArrayShape(['user_id' => "int", 'username' => "string"])]
    public function user(): Model
    {
        return User::query()->find(1);
    }

    public function check(): bool
    {
        return false;
    }

    public static function makeHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyHash(string $password, string $hashed): string
    {
        return password_verify($password, $hash);
    }
}