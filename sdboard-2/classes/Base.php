<?php
abstract class Base {
	protected $db;

	protected function __construct() {
		$this->db = DB::connect(SDBOARD_DSN);
		if (DB::isError($this->db))
			throw BoardException('Unable to connect to database.');
		$this->db->setFetchMode(DB_FETCHMODE_ASSOC);
	}
	
	protected function GetUser($id) {
		$class = 'User_'.SDBOARD_USERTYPE;
		return new $class($id);
	}
}
?>
