<?php


namespace App\Providers;


use Illuminate\Database\Capsule\Manager;

class DatabaseProvider implements ProviderInterface
{

    public function boot(): void
    {
        $manager = new Manager();

        if ('sqlite' == env('DB_DRIVER')) {
            $manager->addConnection([
                'driver' => env('DB_DRIVER'),
                'database' => base_path(env('DB_FILE')),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]);
        } else {
            $manager->addConnection([
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST'),
                'database' => env('DB_NAME'),
                'username' => env('DB_USER'),
                'password' => env('DB_PASS'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]);
        }

        $manager->bootEloquent();
    }
}