<?php
class Category extends Base_DB {
	public function __construct($id) {
		parent::__construct('categories', $id);
	}
	
	public function GetBoards() {
		$boards = array();
		
		$sql = 'SELECT id FROM boards WHERE category = ? ORDER BY name';
		$ids = $this->db->getCol($sql, 0, array($this->id));
		if (DB::isError($ids))
			throw new BoardException('Error retrieving boards.');
		elseif (is_array($ids)) {
			foreach ($ids as $id) {
				$boards[] = new Board($id);
			}
		}

		return $boards;
	}

	public function GetName() {
		return $this->data['name'];
	}

	public function GetWeight() {
		return $this->data['weight'];
	}

	public function SetName($name) {
		return $this->SaveValue(array('name' => $name));
	}

	public function MoveDown() {
		$sql = 'SELECT weight FROM categories WHERE weight > ?';
		$new = $this->db->getOne($sql, array($this->id));
		if (DB::isError($new))
			throw new BoardException('Unable to get new weight.');
		elseif (is_null($new))
			return true;
		else
			return $this->SwapWeight($new);
	}

	public function MoveUp() {
		$sql = 'SELECT weight FROM categories WHERE weight < ?';
		$new = $this->db->getOne($sql, array($this->id));
		if (DB::isError($new))
			throw new BoardException('Unable to get new weight.');
		elseif (is_null($new))
			return true;
		else
			return $this->SwapWeight($new);
	}

	private function SwapWeight($new) {
		$sql = 'UPDATE categories SET weight = ? WHERE weight = ?';
		$result = $this->db->query($sql, array($this->data['weight'], $new));
		if (DB::isError($result))
			throw new BoardException('Unable to swap weights.');
		return $this->SaveValue(array('weight' => $new));
	}
}
?>
