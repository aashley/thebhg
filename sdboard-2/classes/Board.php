<?php
class Board extends Base_DB {
	public function __construct($id) {
		parent::__construct('boards', $id);
	}

	public function GetCategory() {
		return new Category($this->data['category']);
	}

	public function GetDescription() {
		return $this->data['description'];
	}

	public function GetExternalLink() {
		return $this->data['external_url'];
	}

	public function GetModerators() {
		$mods = array();
		
		$sql = 'SELECT person FROM users WHERE mod = 1 AND board = ?';
		$uids = $this->db->getCol($sql, 0, array($this->id));
		if (DB::isError($uids))
			throw new BoardException('Error retrieving moderators.');
		elseif (is_array($uids)) {
			foreach ($uids as $uid) {
				$mods[] = $this->GetUser($uid);
			}
		}

		return $mods;
	}

	public function GetName() {
		return $this->data['name'];
	}

	public function GetRestriction() {
		return $this->data['restriction'];
	}

	public function GetStylesheet() {
		return $this->data['stylesheet'];
	}
	
	public function GetUsers() {
		$mods = array();
		
		$sql = 'SELECT person FROM users WHERE board = ?';
		$uids = $this->db->getCol($sql, 0, array($this->id));
		if (DB::isError($uids))
			throw new BoardException('Error retrieving users.');
		elseif (is_array($uids)) {
			foreach ($uids as $uid) {
				$mods[] = $this->GetUser($uid);
			}
		}

		return $mods;
	}

	public function IsExternalLink() {
		return (strlen($this->data['external_url']) > 0);
	}

	public function IsGuestWritable() {
		return ($this->data['restriction'] == 0);
	}

	public function IsModerator($user) {
		$sql = 'SELECT COUNT(*) FROM users WHERE mod = 1 AND board = ? AND person = ?';
		$count = $this->db->getOne($sql, array($this->id, $user->GetID()));
		if (DB::isError($uids))
			throw new BoardException('Error retrieving moderators.');
		return ($count > 0);
	}

	public function IsUser($user) {
		$sql = 'SELECT COUNT(*) FROM users WHERE board = ? AND person = ?';
		$count = $this->db->getOne($sql, array($this->id, $user->GetID()));
		if (DB::isError($uids))
			throw new BoardException('Error retrieving moderators.');
		return ($count > 0);
	}

	public function IsWorldReadable() {
		return ($this->data['restriction'] <= 2);
	}

	public function IsWorldWritable() {
		return ($this->data['restriction'] <= 1);
	}

	public function MayRead($user) {
		if ($this->IsWorldReadable())
			return true;
		return $this->IsUser($user);
	}

	public function MayPost($user) {
		if ($user->IsGuest())
			return $this->IsGuestWritable();
		if ($this->IsWorldWritable())
			return true;
		return $this->IsUser($user);
	}
}
?>
