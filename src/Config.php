<?php


namespace App;

/**
 * Stab config for app
 */
class Config
{
    public const HOST = 'localhost';

    public const PORT = '5432';

    public const DB_NAME = 'test';

    public const USER = 'postgres';

    public const ADMIN_LOGIN = 'admin';

    public const ADMIN_PASSWORD = '123';

    /*
     * Must be unique, it is wrong
     */
    public const ADMIN_HASH = '999ggg999';
}
