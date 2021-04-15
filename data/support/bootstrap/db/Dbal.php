<?php
namespace support\bootstrap\db;

use Webman\Bootstrap;
// use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
// use app\service\Db;

class Dbal implements Bootstrap
{
	protected static $db_instance = null;

	public static function start($worker)
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
			print_r("bootstra init db_instance\r\n");
			self::$db_instance = DriverManager::getConnection($connectionParams);
		}
		// $config = new Configuration();
		// self::$db_instance = DriverManager::getConnection($connectionParams);
		// $conn->getWrappedConnection()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
	}

	public static function conn() {
		return self::$db_instance;
	}
}

