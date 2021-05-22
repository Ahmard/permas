<?php


namespace App\Utils;


use QuickRoute\Router\Collector;
use QuickRoute\Router\Dispatcher;
use QuickRoute\Router\RouteData;

class Route
{
    private static Collector $collector;


    public function __construct(Collector $collector)
    {
        self::$collector = $collector;
    }

    public static function route(string $routeName): ?RouteData
    {
        return self::getCollector()->route($routeName);
    }

    public static function uri(string $routeName): ?string
    {
        return self::getCollector()->uri($routeName);
    }

    public static function getCollector(): Collector
    {
        return self::$collector;
    }
}