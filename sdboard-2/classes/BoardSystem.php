<?php
class BoardSystem extends Base {
	public function __construct() {
		parent::__construct();
	}

	// Plural functions.
	public function GetBoards() {
		$boards = array();
		
		$sql = 'SELECT boards.id FROM boards, categories WHERE boards.category = categories.id ORDER BY categories.weight, boards.name';
		$ids = $this->db->getCol($sql);
		if (DB::isError($ids))
			throw new BoardException('Error getting board list.');
		elseif (is_array($ids)) {
			foreach ($ids as $id) {
				$boards[] = new Board($id);
			}
		}

		return $boards;
	}

	public function GetCategories() {
		$categories = array();
		
		$sql = 'SELECT id FROM categories ORDER BY weight';
		$ids = $this->db->getCol($sql);
		if (DB::isError($ids))
			throw new BoardException('Error getting category list.');
		elseif (is_array($ids)) {
			foreach ($ids as $id) {
				$categories[] = new Category($id);
			}
		}

		return $categories;
	}

	// Singular functions.
	public function GetBoard($id) {
		return new Board($id);
	}

	public function GetCategory($id) {
		return new Category($id);
	}

	public function GetMessage($id) {
		return new Message($id);
	}

	public function GetTopic($id) {
		return new Topic($id);
	}

	public function GetUser($id) {
		return parent::GetUser($id);
	}

	public function LookupKey($key) {
		$sql = 'SELECT user FROM `keys` WHERE `key` = ?';
		$uid = $this->db->getOne($sql, array($key));
		if (DB::isError($key))
			throw new BoardException('Error looking up login key.');
		elseif (is_null($uid))
			return false;
		return $this->GetUser($uid);
	}
}
?>
