<?php


namespace App\Utils;


use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Console
{
    protected static OutputInterface $output;


    protected static function getOutput(): OutputInterface
    {
        if (!isset(self::$output)){
            self::$output = new ConsoleOutput();
        }

        return self::$output;
    }

    public static function write(string $message): void
    {
        self::getOutput()->write($message);
    }

    public static function writeln(string $message): void
    {
        self::getOutput()->writeln($message);
    }

    public static function info(string $message): void
    {
        self::getOutput()->writeln("<info>$message</info>");
    }

    public static function comment(string $message): void
    {
        self::getOutput()->writeln("<comment>$message</comment>");
    }

    public static function question(string $message): void
    {
        self::getOutput()->writeln("<question>$message</question>");
    }

    public static function error(string $message): void
    {
        self::getOutput()->writeln("<error>$message</error>");
    }
}