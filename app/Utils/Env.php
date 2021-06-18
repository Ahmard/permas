<?php


namespace App\Utils;


use App\Http\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Env
{
    protected static Environment $environment;


    public static function get(string $key): ?string
    {
        return $_ENV[$key] ?? null;
    }

    public static function templateEngine(Request $request): Environment
    {
        if (!isset(self::$environment)) {
            $loader = new FilesystemLoader(views_path());
            self::$environment = new Environment($loader, [
                //'cache' => resources_path("cache/twig"),
            ]);

            //VARIABLES
            self::$environment->addGlobal('env', $_ENV);
            self::$environment->addGlobal('request', $request);
            self::$environment->addGlobal('auth', $request->auth());

            //FUNCTIONS
            self::$environment->addFunction(new TwigFunction('url', 'url'));
            self::$environment->addFunction(new TwigFunction('assets', 'assets'));
            self::$environment->addFunction(new TwigFunction('uri', 'uri'));
            self::$environment->addFunction(new TwigFunction('route', 'route'));
        }

        return self::$environment;
    }
}