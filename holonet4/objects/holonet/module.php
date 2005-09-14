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

		do {

			$filename = $this->name.'/'.$url.'.php';
			$classname = 'page_'.$this->name.'_'.str_replace('/', '_', $url);

			if (file_exists($filename)) {

				include_once $filename;

				if (class_exists($classname)) {

					$page = new $classname();

					if ($page instanceof holonet_page) {

						return $page;

					} else {

						throw bhg_fatal_exception('Found a possible page but it is not of the correct type.');

					}

				}

			}

			$pos = strrpos($url, '/');

			if ($pos === false) {

				$url = '';

			} else {

				$url = substr_replace($url, '', $pos);

			}

		} while (strlen($url) > 0);

		return $this->getDefaultPage();

	}

	public function getDefaultPage() {

		include_once 'holonet/notfound.php';

		return new page_holonet_notfound();

	}

}

?>
