<?php

namespace Mycms;

use PDO;
use Exception;

class Db
{
	private
		$table,
		$columns = [],
		$pdo;
 
	public function __construct($table) 
	{
		$config_db = CONF . "config_db.php";
		if (is_file($config_db)) {
			require_once $config_db;
		} else {
			throw new Exception("Файл не найден");
		}
		
		try {
			$this->pdo = new PDO($db['dsn'],$db['user'],$db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit;
		}
		$this->table = $table; 
		$this->columnsmeta();
		
	}	

	/**
	*	Map data type of argument to a PDO constant
	*	@return int
	*	@param $val scalar
	**/
	private function type($val) {
		switch (gettype($val)) {
			case 'NULL':
				return PDO::PARAM_NULL;
			case 'boolean':
				return PDO::PARAM_BOOL;
			case 'int':
				return PDO::PARAM_INT;
			case 'resource':
				return PDO::PARAM_LOB;
			case 'float':
				return self::PARAM_FLOAT;
			default:
				return PDO::PARAM_STR;
		}
	}
	
	public function select(array $data){
		$sql = "SELECT " . implode(', ', array_keys($this->columns)) . " FROM ".$this->table." WHERE ";
		
		foreach ($data as $key => $value) {
			//last element
			if (!next($data)) {
				$sql .= "$key = :$key ";
			}else{
				$sql .= "$key = :$key AND ";
			}
		}
		
		$stmt = $this->pdo->prepare($sql);

		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value, $this->type($this->columns[$key]) );
		}

		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	private function columnsmeta()
	{
		$q = $this->pdo->query("DESCRIBE $this->table");
		
		$result = $q->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($result as $column){
			$str=strpos($column['Type'], "(");
			$row=substr($column['Type'], 0, $str);

			$this->columns[$column['Field']] = $row;;
		}
	}

}
