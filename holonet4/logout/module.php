<?php

class holonet_module_logout extends holonet_module {

	public function __construct() {

		parent::__construct('logout', 'Logout');

	}

	public function getDefaultPage($trail) {

		include_once 'logout/default.php';
		return new page_logout_default($trail);

	}

}

?>
