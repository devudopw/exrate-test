<?php
namespace app\support;

use Doctrine\DBAL\DriverManager;

class Dbal
{
    protected static $db_instance = null;

    public static function conn()
    {
        if (!self::$db_instance) {
            $configs = config('database');
            $default_config = $configs['connections'][$configs['default']];
            $connectionParams = array(
                'dbname' => $default_config['database'],
                'user' => $default_config['username'],
                'password' => $default_config['password'],
                'host' => $default_config['host'],
                'driver' => 'pdo_mysql',
            );
            self::$db_instance = DriverManager::getConnection($connectionParams);
        }
        return self::$db_instance;
    }
}
