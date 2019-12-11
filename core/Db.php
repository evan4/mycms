<?php

namespace Mycms;

use PDO;
use Exception;

class Db
{

  public function __construct() 
	{
		
	  try {
      new PDO(getenv('DB_DRIVER').":host=".getenv('HOST').";charset=utf8;
        dbname=".getenv('DB_NAME'),
      getenv('DB_USERNAME'), 
      getenv('DB_PASSWORD'), 
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
      ]);
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      exit;
    }
		
	}

}
