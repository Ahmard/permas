<?php


namespace App\Utils;


use Exception;

class Config
{
    protected static array $loaded = [];
    protected array $configuration = [];

    /**
     * @throws Exception
     */
    public function __construct(string $configFile)
    {
        $fileLocation = base_path("config/{$configFile}.php");
        if (!array_key_exists($fileLocation, self::$loaded)) {
            if (!file_exists($fileLocation)) {
                throw new Exception("Configuration file \"{$fileLocation}\" does not exists.");
            }

            $this->configuration = require $fileLocation;
            self::$loaded[$fileLocation] = $this->configuration;
        } else {
            $this->configuration = self::$loaded[$fileLocation];
        }
    }

    /**
     * @throws Exception
     */
    public static function load(string $configFile): Config
    {
        return new Config($configFile);
    }

    /**
     * Get all configurations
     *
     * @return array
     */
    public function all(): array
    {
        return $this->configuration;
    }

    /**
     * Pluck item form configuration
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->configuration[$key] ?? null;
    }
}