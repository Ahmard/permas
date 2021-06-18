<?php

use App\Utils\Console;
use App\RootServer;
use Dotenv\Dotenv;
use QuickRoute\Router\Collector;
use QuickRoute\Router\Dispatcher;
use Spatie\Watcher\Watch;
use Swoole\Http\Server;
use Swoole\Runtime;

require 'vendor/autoload.php';
require 'app/functions.php';

const BASE_DIR = __DIR__ . '/';

set_exception_handler(function (Throwable $exception) {
    dump($exception);
});

$dotEnv = Dotenv::createImmutable(__DIR__)->load();

$collector = Collector::create()
    ->collectFile(__DIR__ . '/resources/routes/web.php')
    ->collectFile(__DIR__ . '/resources/routes/api.php', [
        'prefix' => 'api',
        'name' => 'api.'
    ]);

$dispatcher = Dispatcher::create($collector);

//Runtime configuration
Runtime::enableCoroutine(SWOOLE_HOOK_ALL);

$server = new Server($dotEnv['SERVER_HOST'], $dotEnv['SERVER_PORT']);
$server->on('request', new RootServer($collector, $dispatcher));

$server->on('start', function (Server $server) use ($dotEnv) {
    Console::info("Swoole server started at http://{$dotEnv['SERVER_HOST']}:{$dotEnv['SERVER_PORT']}");

    //Run file watcher
    go(function () use ($server) {
        $paths = [
            __DIR__ . '/app',
            __DIR__ . '/resources/routes/web.php',
            __DIR__ . '/resources/routes/api.php',
            __DIR__ . '/resources/views',
            __FILE__,
        ];

        Watch::paths($paths)
            ->onAnyChange(function (string $changeType, string $newFilePath) use ($server) {
                Console::comment(date('H:i:s') . " > Restarting server => [$changeType: $newFilePath]");
                $server->reload();
            })
            ->start();
    });
});

$server->set([
    'document_root' => __DIR__ . '/public',
    'enable_static_handler' => true,
    'http_parse_post' => true,
]);

$server->start();