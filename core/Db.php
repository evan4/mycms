<?php

namespace Mycms;

use PDO;
use Exception;

class Db
{
    /**
	*	Instantiate class
	*	@param $dsn string
	*	@param $user string
	*	@param $pw string
	*	@param $options array
	**/
	function __construct() {
		$config_db = CONF . "config_db.php";
		if (is_file($config_db)) {
			require_once $config_db;
		} else {
			throw new Exception("Файл не найден");
		}
		
		$this->pdo = new PDO($db['dsn'],$db['user'],$db['pass']);
		$this->engine = $this->pdo->getattribute(PDO::ATTR_DRIVER_NAME);
	}

	/* 'mysql:host=localhost;port=3306;dbname=mysqldb',
    'admin',
    'p455w0rD' */
}