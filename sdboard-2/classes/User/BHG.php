<?php
require_once 'roster.inc';

class User_BHG extends User {
	private $person;
	private $roster;
	
	public function __construct($id) {
		parent::__construct($id);
		$this->roster = new Roster('roster-69god');
		$this->person = $this->roster->GetPerson($id);
	}

	public function GetName() {
		return $this->person->GetName();
	}

	public function GetByline($html) {
		$pos = $this->person->GetPosition();
		$div = $this->person->GetDivision();

		if ($html)
			return '<a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=position&amp;id='.$pos->GetID().'">'.htmlspecialchars($pos->GetName()).'</a>, <a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=division&amp;id='.$div->GetID().'">'.htmlspecialchars($div->GetName()).'</a>';
		else 
			return $pos->GetName().', '.$div->GetName();
	}

	public function GetEmail() {
		return $this->person->GetEmail();
	}

	public function GetSignature($html) {
		if ($html)
			return htmlspecialchars($this->person->IDLine()).'<br /><i>'.htmlspecialchars($this->person->GetQuote()).'</i>';
		else
			return $this->person->GetQuote();
	}

	public function GetInfoURL() {
		return 'http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id='.$this->GetID();
	}

	public function CheckPassword($password) {
		$login = new Login($this->GetID(), $password, 'roster-69god');
		return $login->IsValid();
	}
}
?>
