<?php
abstract class Base_DB extends Base {
	protected $data;
	protected $id;
	protected $table;

	protected function __construct($table, $id) {
		$sql = 'SELECT * FROM `!` WHERE id = ?';
		$fields = $this->db->getRow($sql, array($table, $id));
		if (DB::isError($fields))
			throw new BoardException('Error getting row.');
		foreach ($fields as $key => $value) {
			$this->data[$key] = $value;
		}
	}

	protected function Delete() {
		$sql = 'DELETE FROM `!` WHERE id = ?';
		$result = $this->db->query($sql, array($this->id));
		return (!DB::isError($result));
	}

	protected function GetID() {
		return $this->id;
	}

	protected function SaveValue($fields) {
		$params = array($this->table);
		$sql = 'UPDATE `!` SET ';
		foreach ($fields as $field => $value) {
			$sql .= '`!` = ? ';
			$params[] = $field;
			$params[] = $value;
		}
		$sql .= 'WHERE id = ?';
		$params[] = $this->id;
		$result = $this->db->query($sql, $params);
		return (!DB::isError($result));
	}
}
?>
