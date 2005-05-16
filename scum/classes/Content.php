<?php
class Scum_Content extends Scum_Base {
	public function __construct() {
		parent::__construct();
	}

	public function addPage($name, $content, $type) {
		$result = $this->db->query('INSERT INTO '.SCUM_PREFIX.'content (name, content, type, updated) VALUES (?, ?, ?, UNIX_TIMESTAMP())', array($name, $content, $type));
		return !DB::isError($result);
	}

	public function getPage($name) {
		$count = $this->db->getOne('SELECT COUNT(*) FROM '.SCUM_PREFIX.'content WHERE name = ?', array($name));
		if (DB::isError($count) || $count == 0)
			return false;
		return new Scum_Page($name);
	}

	public function getPages() {
		$names = $this->db->getCol('SELECT name FROM '.SCUM_PREFIX.'content ORDER BY name');
		$pages = array();

		if (DB::isError($names))
			return false;
		elseif (is_array($names))
			foreach ($names as $name)
				$pages[] = new Scum_Page($name);
		
		return $pages;
	}
}

class Scum_Page extends Scum_Base {
	private $data;
	private $name;

	public function __construct($name) {
		parent::__construct();
		
		$this->name = $name;
		$this->updateCache();
	}

	public function delete() {
		$result = $this->db->query('DELETE FROM '.SCUM_PREFIX.'content WHERE name = ?', array($this->name));
		return !DB::isError($result);
	}

	public function getContent() {
		return $this->data['content'];
	}

	public function getLastUpdate() {
		return $this->data['updated'];
	}

	public function getName() {
		return $this->data['name'];
	}

	public function getType() {
		return $this->data['type'];
	}

	public function setContent($content) {
		$result = $this->db->query('UPDATE '.SCUM_PREFIX.'content SET content = ?, updated = UNIX_TIMESTAMP() WHERE name = ?', array($content, $this->name));
		if (DB::isError($result))
			return false;
		$this->updateCache();
		return true;
	}

	public function setName($name) {
		$result = $this->db->query('UPDATE '.SCUM_PREFIX.'content SET name = ?, updated = UNIX_TIMESTAMP() WHERE name = ?', array($name, $this->name));
		if (DB::isError($result))
			return false;
		$this->updateCache();
		$this->name = $name;
		return true;
	}

	public function setType($type) {
		$result = $this->db->query('UPDATE '.SCUM_PREFIX.'content SET type = ?, updated = UNIX_TIMESTAMP() WHERE name = ?', array($type, $this->name));
		if (DB::isError($result))
			return false;
		$this->updateCache();
		return true;
	}

	private function updateCache() {
		$this->data = $this->db->getRow('SELECT * FROM '.SCUM_PREFIX.'content WHERE name = ?', 0, array($this->name));
	}
}
?>
