<?php
include_once('roster.inc');

class CalendarEvent {
	var $db;
	var $id;
	var $section;
	var $poster;
	var $time;
	var $title;
	var $content;

	function CalendarEvent($id, $db) {
		$this->id = (int) $id;
		$this->db = $db;
		$this->UpdateCache();
	}

	function UpdateCache() {
		$result = mysql_query('SELECT * FROM calendar WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			$this->section = $row['section'];
			$this->poster = $row['poster'];
			$this->time = $row['time'];
			$this->title = stripslashes($row['title']);
			$this->content = stripslashes($row['content']);
		}
	}

	function GetID() {
		return $this->id;
	}

	function GetSection() {
		return $this->section;
	}

	function GetPoster() {
		return new Person($this->poster);
	}

	function GetTime() {
		return $this->time;
	}

	function GetTitle() {
		return $this->title;
	}

	function GetContent() {
		return $this->content;
	}

	function SetSection($section) {
		if (mysql_query('UPDATE calendar SET section=' . ((int) $section) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetTime($time) {
		if (mysql_query('UPDATE calendar SET time=' . ((int) $time) . ' WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetTitle($title) {
		if (mysql_query('UPDATE calendar SET title="' . addslashes($title) . '" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function SetContent($content) {
		if (mysql_query('UPDATE calendar SET content="' . addslashes($content) . '" WHERE id=' . $this->id, $this->db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteEvent() {
		if (mysql_query('DELETE FROM calendar WHERE id=' . $this->id, $this->db)) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>
