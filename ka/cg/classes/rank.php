<?php
class CGRank {
	var $id;
	var $fee;
	var $db;

	function CGRank($id, $db) {
		$this->id = $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	function UpdateCache() {
		$result = mysql_query('SELECT fee FROM cg_ranks WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			$this->fee = $row['fee'];
		}
	}

	function GetID() {
		return $this->id;
	}

	function GetRank() {
		return new Rank($this->id);
	}

	function GetFee() {
		return $this->fee;
	}

	function SetFee($fee) {
		if (mysql_query('UPDATE cg_ranks SET fee=' . ((int) $fee) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteRank() {
		if (mysql_query('DELETE FROM cg_ranks WHERE id=' . $this->id, $this->db)) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>
