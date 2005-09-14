<?php

class holonet_module {

	public $name;

	public $title;

	protected $menu;

	public function __construct($name, $title = null) {

		$this->name = $name;
		$this->title = $title;

	}

	public function getMenu() {

		return $this->menu;

	}

	public function setMenu(holonet_menu $menu) {

		$this->menu = $menu;
		$this->menu->id = 'modulemenu';
		$this->menu->showTitle = false;

	}

	public function getPage($url) {

		// Trailing path elements.
		$trail = array();

		do {

			$filename = $this->name.'/'.$url.'.php';
			$classname = 'page_'.$this->name.'_'.str_replace('/', '_', $url);

			if (file_exists($filename)) {

				include_once realpath($filename);

				if (class_exists($classname)) {

					$page = new $classname(array_reverse($trail));

					if ($page instanceof holonet_page) {

						return $page;

					} else {

						throw bhg_fatal_exception('Found a possible page but it is not of the correct type.');

					}

				}

			}

			$pos = strrpos($url, '/');

			if ($pos === false) {

				$trail[] = $url;
				$url = '';

			} else {

				$trail[] = substr($url, $pos + 1);
				$url = substr_replace($url, '', $pos);

			}

		} while (strlen($url) > 0);

		return $this->getDefaultPage(array_reverse($trail));

	}

	public function getDefaultPage($trail) {

		include_once 'holonet/notfound.php';

		return new page_holonet_notfound($trail);

	}

}

?>
