<?php
class Calendar {
	var $db;

	function Calendar($db) {
		$this->db = $db;
	}

	function GetEvents($order = array(), $where = array(), $select = array('id')) {
		$sql = 'SELECT ' . implode(', ', $select);
		$sql .= ' FROM calendar';
		if (count($where)) {
			$sql .= ' WHERE ' . implode(' AND ', $where);
		}
		if (count($order)) {
			$sql .= ' ORDER BY ' . implode(', ', $order);
		}
		$result = mysql_query($sql, $this->db);
		if ($result && mysql_num_rows($result)) {
			$events = array();
			while ($row = mysql_fetch_array($result)) {
				$events[] = new CalendarEvent($row['id'], $this->db);
			}
			return $events;
		}
		else {
			return false;
		}
	}

	function GetEventsByTime($past = -1, $future = -1, $sections = array()) {
		$where = array();
		
		if ($past != -1) {
			$start = time() - ($past * 86400);
			$where[] = 'time > ' . $start;
		}

		if ($future != -1) {
			$end = time() + ($future * 86400);
			$where[] = 'time < ' . $end;
		}

		if (count($sections)) {
			$where[] = 'section IN (' . implode(',', $sections) . ')';
		}
		
		return $this->GetEvents(array('time ASC'), $where);
	}

	function GetEventsByMonth($month, $year, $sections = array()) {
		$start = mktime(0, 0, 0, $month, 1, $year);
		$end = mktime(23, 59, 59, $month + 1, 0, $year);
	
		$where = array("time BETWEEN $start AND $end");

		if (count($sections)) {
			$where[] = 'section IN (' . implode(',', $sections) . ')';
		}
		
		return $this->GetEvents(array('time ASC'), $where);
	}

	function GetEventsByDay($day, $month, $year, $sections = array()) {
		$start = mktime(0, 0, 0, $month, $day, $year);
		$end = mktime(23, 59, 59, $month, $day, $year);
	
		$where = array("time BETWEEN $start AND $end");

		if (count($sections)) {
			$where[] = 'section IN (' . implode(',', $sections) . ')';
		}
		
		return $this->GetEvents(array('time ASC'), $where);
	}

	function GetAllEvents($sections = array()) {
		$where = array();

		if (count($sections)) {
			$where[] = 'section IN (' . implode(',', $sections) . ')';
		}

		return $this->GetEvents(array('time DESC'), $where);
	}

	function Search($terms, $sections = array()) {
		$result = mysql_query('SELECT id, MATCH (title, content) AGAINST ("' . addslashes($terms) . '") AS rel FROM calendar' . (count($sections) ? ' WHERE section IN (' . implode(',', $sections) . ')' : '') . ' ORDER BY rel DESC, time DESC', $this->db);
		if ($result && mysql_num_rows($result)) {
			$events = array();
			while (($row = mysql_fetch_array($result)) && $row['rel'] > 0) {
				$events[] = new CalendarEvent($row['id'], $this->db);
			}
			return $events;
		}
		else {
			return false;
		}
	}

	function AddEvent($section, $poster, $time, $title, $content) {
		$sql = 'INSERT INTO calendar (section, poster, time, title, content) VALUES (' . ((int) $section) . ', ';
		if (get_class($poster) == 'Person') {
			$poster = $poster->GetID();
		}
		$sql .= ((int) $poster) . ', ' . ((int) $time) . ', "' . addslashes($title) . '", "' . addslashes($content) . '")';
		if (mysql_query($sql, $this->db)) {
			return new CalendarEvent(mysql_insert_id($this->db), $this->db);
		}
		else {
			return false;
		}
	}

	function GetEvent($id) {
		return new CalendarEvent($id, $this->db);
	}
}
?>
