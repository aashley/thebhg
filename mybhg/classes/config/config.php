<?php
class Config {
	var $db;

	function Config($db) {
		$this->db = $db;
	}

	function GetValue($name) {
		return new ConfigValue($name, $this->db);
	}

	function GetValues() {
		$sql = 'SELECT name FROM config ORDER BY name';
		$result = mysql_query($sql, $this->db);
		if ($result && mysql_num_rows($result)) {
			$values = array();
			while ($row = mysql_fetch_array($result)) {
				$values[] = new ConfigValue(stripslashes($row['name']), $this->db);
			}
			return $values;
		}
		else {
			return false;
		}
	}
}
?>
