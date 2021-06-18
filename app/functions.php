<?php

use App\Utils\Route;
use JetBrains\PhpStorm\Pure;
use QuickRoute\Router\RouteData;

function url(?string $url = null): string
{
    return "http://{$_ENV['SERVER_HOST']}:{$_ENV['SERVER_PORT']}/{$url}";
}

#[Pure] function assets(?string $url = null): string
{
    return url("assets/$url");
}

function base_path(?string $path = null): string
{
    return BASE_DIR . $path;
}

#[Pure] function resources_path(?string $path = null): string
{
    return base_path("resources/$path");
}

#[Pure] function views_path(?string $path = null): string
{
    return resources_path("views/$path");
}

function route(string $routeName): ?RouteData
{
    return Route::route($routeName);
}

function uri(string $routeName): ?string
{
    return Route::uri($routeName);
}