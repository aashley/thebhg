<?php

include_once 'objects/holonet/menu.php';
include_once 'objects/holonet/module.php';
include_once 'objects/holonet/page.php';

class holonet {

	private $entry = array();

	private $mainmenu = null;

	public $current = null;

	public function __construct() {

		$this->mainmenu = new holonet_menu('mainmenu.xml');
		$this->mainmenu->showTitle = false;
		$this->mainmenu->id = 'mainmenu';

		$parts = explode('/', $_SERVER['PATH_INFO']);

		$url = '';

		for ($i = 0; $i < sizeof($parts); $i++) {

			if (strlen($parts[$i]) > 0) {

				$this->current = $this->$parts[$i];

				$url = implode('/', array_slice($parts, $i + 1));

				break;

			}

		}

		if (is_null($this->current))
			$this->current = $this->holonet;

	}

	public function execute() {

		$url = trim($_SERVER['PATH_INFO'], '/');
		$slash = strpos($url, '/');
		if ($slash !== false) {

			$url = substr($url, $slash + 1);
			
		}

		$page = $this->current->getPage($url);

		$page->display();

	}

	public function getMenu() {
		return $this->mainmenu;
	}

	public function __get($e) {

		$e = strtolower($e);

		if (	 isset($this->entry[$e])
				&& $this->entry[$e] instanceof holonet_module) {

			return $this->entry[$e];

		} else {

			$filename = $e.'/module.php';

			if (!file_exists($filename))
				throw new bhg_fatal_exception('Can not location holonet module.');

			include_once $filename;

			$classname = 'holonet_module_'.$e;

			$this->entry[$e] = new $classname();

			if ($this->entry[$e] instanceof holonet_module) {

				return $this->entry[$e];

			} else {

				unset($this->entry[$e]);

				throw new bhg_fatal_exception('Invalid holonet module requested.');

			}

		}

	}

}

$GLOBALS['holonet'] = new holonet();

?>
