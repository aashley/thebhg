<?php
require_once 'Auth/PrefManager.php';

abstract class User extends Base {
	protected $id;
	private $prefManager;
	
	public function __construct($id) {
		parent::__construct();
		$this->id = $id;
		$this->prefManager = new Auth_PrefManager(SDBOARD_DSN, null, 0);
	}

	public function GetID() {
		return $this->id;
	}
	
	abstract public function GetName();
	abstract public function GetByline($html);
	abstract public function GetEmail();
	abstract public function GetSignature($html);
	abstract public function CheckPassword($password);

	public function GetBoards() {
		$boards = array();

		$sql = 'SELECT id FROM boards WHERE restriction < 2';
		$ids = $this->db->getCol($sql);
		if (DB::isError($ids))
			throw new BoardException('Error getting board listing.');
		elseif (!is_array($ids))
			$ids = array();

		$sql = 'SELECT board FROM users WHERE person = ?';
		$uids = $this->db->getCol($sql, 0, array($this->GetID()));
		if (DB::isError($uids))
			throw new BoardException('Error getting user listing.');
		elseif (!is_array($uids))
			$ids = array_merge($ids, $uids);

		foreach (array_unique($ids) as $id) {
			$boards[] = new Board($id);
		}
		return $boards;
	}

	public function GetInfoURL() {
		return '/user/'.$this->GetID();
	}

	public function GetPref($name) {
		return $this->prefManager->getPref($this->GetID(), $name);
	}
	
	public function GetPosts() {
		$sql = 'SELECT COUNT(*) FROM messages WHERE deleted = 0 AND poster = ?';
		$num = $this->db->getOne($sql, array($this->GetID()));
		if (DB::isError($num))
			throw new BoardException('Error getting post total.');
		return $num;
	}

	public function SetPref($name, $value) {
		return $this->prefManager->setPref($this->GetID(), $name, $value);
	}

	public function IsGuest() {
		return false;
	}

	public function CheckKey($userKey) {
		return ($this->GetKey() == $userKey);
	}

	public function GetKey() {
		$sql = 'SELECT `key` FROM `keys` WHERE user = ?';
		$key = $this->db->getOne($sql, array($this->GetID()));
		if (DB::isError($key))
			throw new BoardException('Unable to retrieve user key.');
		elseif (is_null($key))
			$key = $this->NewKey();
		return $key;
	}

	public function NewKey() {
		$seed = md5(microtime(true) . $this->GetID() . $this->GetName() . $this->GetByline(false) . $this->GetEmail() . $this->GetSignature(false) . mt_rand());
		$sql = 'REPLACE INTO `keys` (`key`, user) VALUES (?, ?)';
		$result = $this->db->query($sql, array($seed, $this->GetID()));
		if (DB::isError($result))
			throw new BoardException('Unable to save the new key.');
		return $seed;
	}
}
?>
