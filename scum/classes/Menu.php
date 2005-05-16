<?php
class Scum_Menu extends Scum_Base {
	public function __construct() {
		parent::__construct();
	}

	public function addItem($name, $link) {
		$topWeight = $this->db->getOne('SELECT weight FROM '.SCUM_PREFIX.'menu ORDER BY weight DESC LIMIT 1') + 1;
		
		$result = $this->db->query('INSERT INTO '.SCUM_PREFIX.'menu (name, link, weight) VALUES (?, ?, ?)', array($name, $link, $topWeight));
		return !DB::isError($result);
	}

	public function getItem($id) {
		return new Scum_MenuItem($id);
	}

	public function getItems() {
		$ids = $this->db->getCol('SELECT id FROM '.SCUM_PREFIX.'menu ORDER BY weight');
		$items = array();
		if (DB::isError($ids))
			return false;
		elseif (is_array($ids))
			foreach ($ids as $id)
				$items[] = new Scum_MenuItem($id);

		return $items;
	}
}

class Scum_MenuItem extends Scum_Base {
	private $data;
	private $id;

	public function __construct($id) {
		parent::__construct();

		$this->id = $id;
		$this->updateCache();
	}

	public function delete() {
		$result = $this->db->query('DELETE FROM '.SCUM_PREFIX.'menu WHERE id = ?', array($this->id));
		return !DB::isError($result);
	}

	public function getID() {
		return $this->id;
	}

	public function getLink() {
		return $this->data['link'];
	}

	public function getName() {
		return $this->data['name'];
	}

        public function moveUp() {
                $newWeight = $this->db->getOne('SELECT weight FROM '.SCUM_PREFIX.'menu WHERE weight < ? ORDER BY weight DESC LIMIT 1', array($this->data['weight']));
                if (DB::isError($newWeight))
                        return false;
                elseif (!is_null($newWeight))
                        return $this->swapWeight($newWeight);
        }

        public function moveDown() {
                $newWeight = $this->db->getOne('SELECT weight FROM '.SCUM_PREFIX.'menu WHERE weight > ? ORDER BY weight ASC LIMIT 1', array($this->data['weight']));
                if (DB::isError($newWeight))
			return false;
                elseif (!is_null($newWeight))
                        return $this->swapWeight($newWeight);
        }

	public function setLink($link) {
		$result = $this->db->query('UPDATE '.SCUM_PREFIX.'menu SET link = ? WHERE id = ?', array($link, $this->id));
		if (DB::isError($result))
			return false;
		$this->updateCache();
		return true;
	}

	public function setName($name) {
		$result = $this->db->query('UPDATE '.SCUM_PREFIX.'menu SET name = ? WHERE id = ?', array($name, $this->id));
		if (DB::isError($result))
			return false;
		$this->updateCache();
		return true;
	}

        private function swapWeight($weight) {
                $result = $this->db->query('UPDATE '.SCUM_PREFIX.'menu SET weight = ? WHERE weight = ?', array($this->data['weight'], $weight));
                if (DB::isError($result))
			return false;

                $result = $this->db->query('UPDATE '.SCUM_PREFIX.'menu SET weight = ? WHERE id = ?', array($weight, $this->id));
                if (DB::isError($result))
			return false;

		return true;
        }

	private function updateCache() {
		$this->data = $this->db->getRow('SELECT * FROM '.SCUM_PREFIX.'menu WHERE id = ?', 0, array($this->id));
	}
}
?>
