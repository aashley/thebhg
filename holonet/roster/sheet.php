<?php
// Some general functions to handle Character Sheets more easily are included
// here.

// We can replace this with a better database connection if need be.
$sheet_db = $roster->roster_db;

// Creates a blank character sheet for the given person.
function create_blank_sheet($pleb) {
	global $sheet_db;
	
	if (mysql_query('INSERT INTO cs_sheets (person, time) VALUES (' . $pleb->GetID() . ', 0)', $sheet_db)) {	
		// Fill out all the other fields with default values (0 for
		// integer and dropdown fields, '' for text ones).
		$fields = mysql_query('SELECT id, type FROM cs_fields', $sheet_db);
		while ($field = mysql_fetch_array($fields)) {
			if ($field['type'] == 'text') {
				$default = '""';
			}
			else {
				$default = '0';
				mysql_query('INSERT INTO cs_bonus_points (person, field, points) VALUES (' . $pleb->GetID() . ', '. $field['id'] . ', 0)', $sheet_db);
			}
			mysql_query('INSERT INTO cs_sheet_fields (person, field, value) VALUES (' . $pleb->GetID() . ', ' . $field['id'] . ', ' . $default . ')', $sheet_db);
		}
		return true;
	}
	else {
		// The person already has a CS.
		return false;
	}
}

class Sheet {
	var $person;
	var $last_update;
	var $fields;
	var $status;

	function Sheet($person) {
		global $sheet_db;

		$this->person = $person;
		$result = mysql_query('SELECT * FROM cs_sheets WHERE person=' . $person->GetID(), $sheet_db);
		if (mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			$this->last_update = $row['time'];
			$this->status = $row['status'];
		}
		else {
			create_blank_sheet($person);
		}

		$fields_result = mysql_query('SELECT id FROM cs_fields ORDER BY class, name', $sheet_db);
		while ($field = mysql_fetch_array($fields_result)) {
			$this->fields[$field['id']] = new Field($this, $field['id']);
		}
	}

	function GetField($id) {
		return $this->fields[$id];
	}

	function GetFields() {
		return $this->fields;
	}

	function GetPerson() {
		return $this->person;
	}

	function GetLastUpdate() {
		return $this->last_update;
	}

	function GetStatus() {
		return $this->status;
	}

	function MarkOK($save) {
		global $sheet_db;
		
		mysql_query('UPDATE cs_sheets SET status="ok" WHERE person=' . $this->person->GetID(), $sheet_db);
		$result = mysql_query('SELECT cs_pending_fields.*, cs_fields.type FROM cs_fields, cs_pending_fields WHERE cs_fields.id=cs_pending_fields.field AND cs_pending_fields.person=' . $this->person->GetID(), $sheet_db);
		if (mysql_num_rows($result)) {
			if ($save) {
				while ($row = mysql_fetch_array($result)) {
					mysql_query('UPDATE cs_sheet_fields SET value="' . addslashes($row['value']) . '" WHERE person=' . $this->person->GetID() . ' AND field=' . $row['field'], $sheet_db);
					if ($row['type'] == 'int') {
						mysql_query('UPDATE cs_bonus_points SET points=' . $row['bonus'] . ' WHERE person=' . $this->person->GetID() . ' AND field=' . $row['field'], $sheet_db);
					}
				}
			}
			mysql_query('DELETE FROM cs_pending_fields WHERE person=' . $this->person->GetID(), $sheet_db);
		}
	}

	function MarkNew() {
		global $sheet_db;
		mysql_query('UPDATE cs_sheets SET status="new" WHERE person=' . $this->person->GetID(), $sheet_db);
	}

	function MarkChanged() {
		global $sheet_db;
		mysql_query('UPDATE cs_sheets SET status="changed" WHERE person=' . $this->person->GetID(), $sheet_db);
	}

	// Bonus points. Bleh.

	// For the purposes of this function, a class of 0 means generic, and
	// -1 means "any abilities".
	function GetBonusPoints($class) {
		global $sheet_db;
		
		if (is_object($class)) {
			$class = $class->GetID();
		}
		
		$result = mysql_query('SELECT * FROM cs_used_xp WHERE class=' . $class . ' AND person=' . $this->person->GetID(), $sheet_db);
		$bp = mysql_num_rows($result);
		switch ($class) {
			case 4:
				$bp += $this->GetTalentsBonus();
				break;
			case 5:
				$bp += $this->GetSkillsBonus();
				break;
			case 6:
				$bp += $this->GetKnowledgesBonus();
				break;
			case 0:
				$bp += $this->GetGenericBonus();
		}

		return $bp;
	}
	
	function GetTalentsBonus() {
		$medals = $this->person->GetMedals();
		if (count($medals)) {
			$medal = $medals[0]->GetMedal();
			$group = $medal->GetGroup();
			switch ($group->GetID()) {
				case 1:
					return 5;
				case 2:
					return 4;
				case 3:
					return 3;
				case 4:
					return 2;
			}
			foreach ($medals as $am) {
				$medal = $am->GetMedal();
				$group = $medal->GetGroup();
				if ($group->GetID() == 7 || $group->GetID() == 9 || $group->GetID() == 12) {
					return 1;
				}
			}
		}
		return 0;
	}

	function GetSkillsBonus() {
		$rank = $this->person->GetRank();
		switch ($rank->GetID()) {
			case 16: case 17:
				return 5;
			case 13: case 14: case 15: case 19: case 20:
				return 4;
			case 11: case 12:
				return 3;
			case 9: case 10:
				return 2;
			case 6: case 7: case 8:
				return 1;
			default:
				return 0;
		}
	}

	function GetKnowledgesBonus() {
		$elapsed = time() - $this->person->GetJoinDate();
		if ($elapsed > 126144000) {
			return 5;
		}
		elseif ($elapsed > 94608000) {
			return 4;
		}
		elseif ($elapsed > 63072000) {
			return 3;
		}
		elseif ($elapsed > 31536000) {
			return 2;
		}
		elseif ($elapsed > 15768000) {
			return 1;
		}
		else {
			return 0;
		}
	}

	function GetGenericBonus() {
		switch ($this->fields[56]->GetRealValue()) {
			case 5:
				return 5;
			case 6:
				return 4;
			case 7:
				return 3;
			case 8:
				return 2;
			case 9:
				return 1;
		}
		return 0;
	}

	// XP. Double bleh.

	function GetUnusedXP() {
		global $sheet_db;

		$result = mysql_query('SELECT * FROM cs_unused_xp WHERE person=' . $this->person->GetID(), $sheet_db);
		if (mysql_num_rows($result)) {
			return mysql_result($result, 0, 'xp');
		}
		else {
			return 0;
		}
	}

	function AddXP($xp) {
		global $sheet_db;
		
		$result = mysql_query('SELECT xp FROM cs_unused_xp WHERE person=' . $this->person->GetID(), $sheet_db);
		if ($result && mysql_num_rows($result)) {
			mysql_query('UPDATE cs_unused_xp SET xp=xp+' . $xp . ' WHERE person=' . $this->person->GetID(), $sheet_db);
		}
		else {
			mysql_query('INSERT INTO cs_unused_xp (person, xp) VALUES (' . $this->person->GetID() . ', ' . $xp . ')', $sheet_db);
		}
	}

	function PurchaseBonusPoint($class, $xp) {
		global $sheet_db;
		
		mysql_query('UPDATE cs_unused_xp SET xp=xp-' . $xp . ' WHERE person=' . $this->person->GetID(), $sheet_db);
		mysql_query('INSERT INTO cs_used_xp (person, class) VALUES (' . $this->person->GetID() . ', ' . $class . ')', $sheet_db);
	}
}

class SheetClass {
	var $id;
	var $name;
	var $limit;
	var $help;

	function SheetClass($id) {
		global $sheet_db;

		$this->id = $id;
		$result = mysql_query('SELECT * FROM cs_classes WHERE id=' . $id, $sheet_db);
		$row = mysql_fetch_array($result);
		$this->name = stripslashes($row['name']);
		$this->limit = stripslashes($row['limit']);
		$this->help = stripslashes($row['help']);
	}

	function GetID() {
		return $this->id;
	}

	function GetName() {
		return $this->name;
	}

	function GetLimit() {
		return $this->limit;
	}

	function GetHelp() {
		return $this->help;
	}
}

class Field {
	var $id;
	var $class;
	var $name;
	var $type;
	var $real;
	var $bonus;
	var $text;
	var $dropdowns;
	var $sheet;
	var $limit;
	var $person;
	var $help;

	function Field($sheet, $id) {
		global $sheet_db;
		$pleb = $sheet->GetPerson();
		$this->person = $pleb;
		$this->sheet = $sheet;
		$this->id = $id;
		
		$field_result = mysql_query('SELECT * FROM cs_fields WHERE id=' . $id, $sheet_db);
		$field = mysql_fetch_array($field_result);
		$this->type = $field['type'];
		$this->name = stripslashes($field['name']);
		$this->class = new SheetClass($field['class']);
		$this->limit = $field['limit'];
		$this->help = stripslashes($field['help']);

		if ($this->type == 'dropdown') {
			$dd_result = mysql_query('SELECT * FROM cs_field_options WHERE field=' . $id . ' OR class=' . $field['class'] . ' ORDER BY name ASC', $sheet_db);
			$this->dropdowns[0] = '';
			while ($dd = mysql_fetch_array($dd_result)) {
				$this->dropdowns[$dd['id']] = stripslashes($dd['name']);
			}
		}
		
		$result = mysql_query('SELECT * FROM cs_sheet_fields WHERE person=' . $pleb->GetID() . ' AND field=' . $id, $sheet_db);
		if (!mysql_num_rows($result)) {
			mysql_query('INSERT INTO cs_sheet_fields (person, field) VALUES (' . $pleb->GetID() . ', ' . $id . ')', $sheet_db);
			$result = mysql_query('SELECT * FROM cs_sheet_fields WHERE person=' . $pleb->GetID() . ' AND field=' . $id, $sheet_db);
		}
		$row = mysql_fetch_array($result);
		if ($this->type == 'text') {
			$this->text = stripslashes($row['value']);
		}
		else {
			$this->real = (int) $row['value'];
			$bp_result = mysql_query('SELECT * FROM cs_bonus_points WHERE person=' . $pleb->GetID() . ' AND field=' . $id, $sheet_db);
			if (mysql_num_rows($bp_result)) {
				$this->bonus = mysql_result($bp_result, 0, 'points');
			}
			else {
				$this->bonus = 0;
			}
		}
	}

	function GetID() {
		return $this->id;
	}

	function GetName() {
		return $this->name;
	}

	function GetType() {
		return $this->type;
	}
	
	function GetClass() {
		return $this->class;
	}

	function GetLimit() {
		return $this->limit;
	}

	function GetHelp() {
		return $this->help;
	}

	function GetValue() {
		if ($this->type == 'text') {
			return $this->text;
		}
		elseif ($this->type == 'dropdown') {
			return $this->dropdowns[$this->real];
		}
		else {
			$str = str_repeat('X', $this->real);
			$str .= str_repeat('*', $this->bonus);
			$str = str_pad($str, $this->limit, '0', STR_PAD_RIGHT);
			return $str;
		}
	}

	function GetRealValue() {
		return $this->real;
	}

	function GetBonusPoints() {
		return $this->bonus;
	}

	function GetOptions() {
		return $this->dropdowns;
	}

	function ChangeText($text) {
		global $sheet_db;
		
		$this->text = $text;
		mysql_query('DELETE FROM cs_pending_fields WHERE person=' . $this->person->GetID() . ' AND field=' . $this->id, $sheet_db);
		mysql_query('INSERT INTO cs_pending_fields (person, field, value, bonus) VALUES (' . $this->person->GetID() . ', ' . $this->id . ', "' . addslashes($text) . '", 0)', $sheet_db);
		$this->UpdateTime();
	}

	function ChangePoints($real = 0, $bonus = 0) {
		global $sheet_db;

		$this->real = $real;
		$this->bonus = $bonus;
		$pleb = $this->sheet->GetPerson();
		mysql_query('DELETE FROM cs_pending_fields WHERE person=' . $pleb->GetID() . ' AND field=' . $this->id, $sheet_db);
		mysql_query('INSERT INTO cs_pending_fields (person, field, value, bonus) VALUES (' . $pleb->GetID() . ', ' . $this->id . ', "' . number_format($real) . '", ' . number_format($bonus) . ')', $sheet_db);
		$this->UpdateTime();
	}

	function ChangeOption($option) {
		global $sheet_db;

		$this->real = $option;
		$pleb = $this->sheet->GetPerson();
		mysql_query('DELETE FROM cs_pending_fields WHERE person=' . $pleb->GetID() . ' AND field=' . $this->id, $sheet_db);
		mysql_query('INSERT INTO cs_pending_fields (person, field, value, bonus) VALUES (' . $pleb->GetID() . ', ' . $this->id . ', "' . number_format($option) . '", 0)', $sheet_db);
		$this->UpdateTime();
	}

	function UpdateTime() {
		global $sheet_db;

		$pleb = $this->sheet->GetPerson();
		mysql_query('UPDATE cs_sheets SET time=UNIX_TIMESTAMP() WHERE person=' . $pleb->GetID(), $sheet_db);
	}
	
}
?>
