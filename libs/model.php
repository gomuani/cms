<?php
class Model{
	function __construct($id){
		$this->id = $id;
	}
	function add(){
		$table = $this->table;
		$db = $this->db;
		unset($this->id);
		unset($this->table);
		unset($this->db);
		$this->id = $db->insert($table, $this);
		return true;
	}
	function modify(){
		$after = 'WHERE id = ' . $this->id;
		$table = $this->table;
		$db = $this->db;
		unset($this->id);
		unset($this->table);
		unset($this->db);
		$db->update($table, $this, $after);
		return true;
	}
	function remove(){
		$after = 'WHERE id = ' . $this->id;
		$this->db->delete($this->table, $after);
		return true;
	}
	function get($after = null){
		$result = $this->db->select($this->table, $after);
		return $result;
	}
	function getById(){
		$after = 'WHERE id = ' . $this->id;
		return $this->get($after);
	}
}
?>