<?php
class User_Default extends User {
	public function __construct() {
		parent::__construct(0);
	}

	public function GetName() {
		return 'Guest';
	}

	public function GetByline($html) {
		return '';
	}

	public function GetEmail() {
		return '';
	}

	public function GetSignature($html) {
		return '';
	}

	public function CheckPassword($password) {
		return true;
	}

	public function IsGuest() {
		return true;
	}
}
?>
