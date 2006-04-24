<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_administration_my_transfer extends holonet_page {

	public function __contruct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Request Transfer');

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

}

?>
