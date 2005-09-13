<?php

class holonet {

	private $entry = array();

	private $mainmenu = null;

	public function __construct() {

		$this->mainmenu = new Holonet_Menu('mainmenu.xml');

	}

	public function __get($e) {

		$e = strtolower($e);

		if (	 isset($this->entry[$e])
				&& $this->entry[$e] instanceof holonet_module) {

			return $this->entry[$e];

		} else {

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

?>
