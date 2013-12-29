<?php
class Database extends PDO{
private $host = HOST;
private $user = USER;
private $pass = PASS;
private $dbname = DATABASE;
private $error;
private $stmt;

	function __construct(){
		// Set Database Source Name
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		// Set options
		$options = array(
		    PDO::ATTR_PERSISTENT    => true,
		    PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
		);
		// Create a new PDO instance
		try{
			parent::__construct($dsn, $this->user, $this->pass, $options);
		}
		// Catch any errors
		catch(PDOException $e){
			$this->error = "Error.";
			echo $this->error;
			file_put_contents(LOGS . date('Y-m-d_H-i-s') . '.txt', $e->getMessage() . "\n", FILE_APPEND);
		}
	}

	private function query($query){
		$this->stmt = $this->prepare($query);
	}

	private function bind($param, $value, $type = null){
		if(is_null($type)):
			switch(true):
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			endswitch;
		endif;
		$this->stmt->bindValue($param, $value, $type);
	}

	private function execute(){
		return $this->stmt->execute();
	}

	private function resultset(){
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	private function single(){
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	private function rows(){
		return $this->stmt->rowCount();
	}

	private function lastId(){
		return $this->lastInsertId();
	}

	private function initTransaction(){
		return $this->beginTransaction();
	}

	private function endTransaction(){
		return $this->commit();
	}

	private function cancelTransaction(){
		return $this->rollBack();
	}

	function select($fields){
		$columns = implode(", ", array_keys($fields));
		$this->select = "SELECT $columns";
	}

	function where($string){
		$this->where = "WHERE $string";
	}

	function doSelect($table, $after = null){
		if(is_null($after)):
			$query = "SELECT * FROM $table";
		else:
			$query = "SELECT * FROM $table $after";
		endif;
		$this->query($query);
		$this->execute();
		if($this->rows() == 1):
			return $this->single();
		else:
			return $this->resultset();
		endif;
	}

	function doInsert($table, $data){
		$data = get_object_vars($data);
		$columns = implode(", ", array_keys($data));
		$values = ':' . implode(', :', array_keys($data));
		$query = "INSERT INTO $table ($columns) VALUES ($values)";
		$this->query($query);
		foreach ($data as $column => $value):
			$this->bind(':' . $column, $value);
		endforeach;
		$this->execute();
		return $this->lastId();
	}

	function doUpdate($table, $data, $after){
		$sets = null;
		foreach ($data as $column => $value):
			$sets .= "$column = :$column,";
		endforeach;
		$sets = rtrim($sets, ',');
		$query = "UPDATE $table SET $sets $after";
		$this->query($query);
		foreach ($data as $column => $value):
			$this->bind(':' . $column, $value);
		endforeach;
		$this->execute();
		return true;
	}

	function delete($table, $after){
		$query = "DELETE FROM $table $after";
		$this->query($query);
		$this->execute();
		return true;
	}

}

?>