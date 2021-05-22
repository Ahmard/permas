<?php


use Spatie\Watcher\Watch;


require 'vendor/autoload.php';

Co\run(function () use ($server){
    Watch::paths(__DIR__ . '/app', __FILE__)
        ->onAnyChange(function (string $changeType, string $newFilePath) use ($server){
            Console::comment("Restarting server => $changeType: $newFilePath");
            $server->reload();
        })
        ->start();
});
