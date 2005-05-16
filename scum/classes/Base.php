<?php
include_once 'DB.php';

abstract class Scum_Base {
	protected $db;

	protected function __construct() {
		$this->db = DB::connect(SCUM_DSN);
		$this->db->setFetchMode(DB_FETCHMODE_ASSOC);
	}

	protected function isAdmin(Person $person) {
		global $users;

		$div = $person->GetDivision()->GetID();
		$pos = $person->GetPosition()->GetID();
		$rid = $person->GetID();

		foreach ($users as $type => $allow) {
			switch ($type) {
				case 'division':
					if (in_array($div, $allow))
						return true;
					break;
					
				case 'position':
					if (in_array($pos, $allow))
						return true;
					break;

				case 'uid':
					if (in_array($rid, $allow))
						return true;
					break;
			}
		}

		return false;
	}
}

?>
