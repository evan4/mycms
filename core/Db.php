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
		try {
			$this->pdo = new PDO(getenv('DB_DRIVER').":host=".getenv('HOST').";charset=utf8;
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
		$this->table = $table; 
		$this->columnsmeta();
		
	}	

	/**
	*	Map data type of argument to a PDO constant
	*	@return int
	*	@param $val scalar
	**/
	private function type($val) 
	{
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
	
	public function select(array $data)
	{
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

		$this->pdo->beginTransaction();

		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value, $this->type($this->columns[$key]) );
		}

		$stmt->execute();
		
		$this->pdo->commit();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function insert(array $data)
	{
		$fields = implode(', ', array_keys($this->columns));
	
		$sql = "INSERT INTO " .$this->table. " (". $fields . ") VALUES (";

		foreach ($data as $value) {
			//last element
			if (!next($data)) {
				$sql .= "?, ";
			}else{
				$sql .= "?)";
			}
		}

		$stmt = $this->pdo->prepare($sql);

		try {
			$this->pdo->beginTransaction();

			$res = $stmt->execute(array_values($data));

			$this->pdo->commit();
			return $res;

		} catch (Exception $e) {
			$this->pdo->rollBack();
			echo "Failed: " . $e->getMessage();
		}
		
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
