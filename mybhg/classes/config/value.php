<?php
class ConfigValue {
	var $data;
	var $db;

	function ConfigValue($name, $db) {
		$this->db = $db;
		$sql = 'SELECT * FROM config WHERE name="' . addslashes($name) . '"';
		if ($result = mysql_query($sql, $db)) {
			$this->data = mysql_fetch_array($result);
		}
	}

	function GetDescription() {
		return stripslashes($this->data['description']);
	}

	function GetName() {
		return stripslashes($this->data['name']);
	}

	function GetValue() {
		return stripslashes($this->data['value']);
	}

	function IsDeleted() {
		return is_null($this->data['value']);
	}

	function IsNotDeleted() {
		return !$this->IsDeleted();
	}

	function SetDescription($description) {
		$sql = 'UPDATE config SET description="' . addslashes($description) . '" WHERE name="' . $this->data['name'] . '"';
		if (mysql_query($sql, $this->db)) {
			$this->data['description'] = $description;
			return true;
		}
		return false;
	}

	function SetValue($value) {
		$sql = 'UPDATE config SET value="' . addslashes($value) . '" WHERE name="' . $this->data['name'] . '"';
		if (mysql_query($sql, $this->db)) {
			$this->data['value'] = $value;
			return true;
		}
		return false;
	}

	function Delete() {
		$sql = 'UPDATE config SET value=NULL WHERE name="' . $this->data['name'] . '"';
		if (mysql_query($sql, $this->db)) {
			$this->data['value'] = null;
			return true;
		}
		return false;
	}
}
?>
