<?php
/**
 * A timeline event.
 *
 * @access public
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @package Timeline
 */
class TLEvent {
	var $id;
	var $day;
	var $month;
	var $year;
	var $content;
	var $categories;
	var $categorised;
	var $db;

	function TLEvent($id, &$db) {
		$this->id = (int) $id;
		$this->db = $db;
		
		$result = mysql_query('SELECT * FROM timeline WHERE eid=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			$this->day = $row['did'];
			$this->month = $row['mid'];
			$this->year = $row['yid'];
			$this->content = stripslashes($row['content']);
			if ($row['category']) {
				$this->categories = explode(',', $row['category']);
				$this->categorised = true;
			}
			else {
				$this->categories = array();
				$this->categorised = false;
			}
		}
	}

	function GetID() {
		return $this->id;
	}

	function GetDay() {
		return $this->day;
	}

	function GetMonth() {
		return $this->month;
	}

	function GetYear() {
		return $this->year;
	}

	function GetTimestamp() {
		return mktime(0, 0, 0, $this->month, $this->day, $this->year);
	}

	function GetFormattedDate() {
		return $this->day . ' ' . date('F', mktime(0, 0, 0, $this->month)) . ' ' . $this->year;
	}

	function GetContent() {
		return $this->content;
	}

	function GetCategories() {
		$categories = array();
		if (count($this->categories)) {
			foreach ($this->categories as $cat) {
				$categories[] = new TLCategory($cat, $this->db);
			}
		}
		return $categories;
	}

	function IsCategorised() {
		return $this->categorised;
	}

	function SetTime($day, $month, $year) {
		if (mysql_query("UPDATE timeline SET did='$day', mid='$month', yid='$year' WHERE eid=" . $this->id, $this->db)) {
			$this->day = $day;
			$this->month = $month;
			$this->year = $year;
			return true;
		}
		else {
			return false;
		}
	}

	function SetTimestamp($ts) {
		return $this->SetTime(date('j', $ts), date('n', $ts), date('Y', $ts));
	}

	function SetContent($content) {
		if (mysql_query('UPDATE timeline SET content="' . addslashes($content) . '" WHERE eid=' . $this->id, $this->db)) {
			$this->content = $content;
			return true;
		}
		else {
			return false;
		}
	}

	function SetCategories($categories) {
		if (count($categories)) {
			$ctext = implode(',', $categories);
		}
		else {
			$ctext = '';
		}
		if (mysql_query('UPDATE timeline SET category="' . $ctext . '" WHERE eid=' . $this->id, $this->db)) {
			$this->categories = $categories;
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteEvent() {
		return !!mysql_query('DELETE FROM timeline WHERE eid=' . $this->id, $this->db);
	}
}
?>
