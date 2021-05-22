<?php


namespace App\Utils;


use PDO;
use PDOException;

class Database
{
    private static PDO $connection;

    /**
     * Gets database connection
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        return self::createConnection();
    }

    /**
     * Create database connection, note that this connection follows singleton pattern, which means
     * once a connection is created it cannot be changed.
     * This is just for security reasons.
     * @return PDO
     * @throws PDOException
     */
    public static function createConnection(): PDO
    {
        if (!isset(self::$connection)) {
            $driver = Env::get('DB_DRIVER');
            $host = Env::get('DB_HOST');
            $name = Env::get('DB_NAME');
            $user = Env::get('DB_USER');
            $pass = Env::get('DB_PASS');

            //create db connection
            self::$connection = new PDO("{$driver}:host={$host};dbname={$name}", $user, $pass);
            //convert all db errors to exceptions
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        }

        return self::$connection;
    }

    /**
     * Sanitize database input string
     *aa
     * @param string $input
     * @return string
     */
    public static function sanitize(string $input): string
    {
        $input = utf8_encode($input);   //convert all chars to utf-8
        $input = htmlspecialchars($input);
        return $input;
    }
}