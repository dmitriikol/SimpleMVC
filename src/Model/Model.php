<?php


namespace App\Model;

use App\Config;

abstract class Model
{
    // TODO
    static $db = null;

    protected static function getDB()
    {
        if (static::$db === null) {
            $dsn = 'pgsql:host='. Config::HOST .';port='. Config::PORT .';dbname='. Config::DB_NAME .';user='. Config::USER;
            static::$db = new \PDO($dsn);
        }

        return static::$db;
    }
}