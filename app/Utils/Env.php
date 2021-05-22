<?php


namespace App\Utils;


use App\Http\Request;
use League\Plates\Engine;

class Env
{
    protected static Engine $templates;


    public static function get(string $key): ?string
    {
        return $_ENV[$key] ?? null;
    }

    public static function templateEngine(Request $request): Engine
    {
        if (!isset(self::$templates)) {
            self::$templates = (new Engine(BASE_DIR . 'resources/views'));
            self::$templates->addData([
                'request' => $request,
                'auth' => $request->auth(),
            ]);
        }

        return self::$templates;
    }
}