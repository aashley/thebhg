<?php

class holonet_module_holonet extends holonet_module {

	public function __construct() {

		parent::__construct('holonet', 'Holonet');

		$this->setMenu(new holonet_menu('holonet/menu.xml'));

	}

	public function getDefaultPage() {

		include_once 'holonet/default.php';

		return new page_holonet_default();

	}

}

?>
