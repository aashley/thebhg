<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_administration extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Roster Administration');

		$this->addBodyContent('<p>Hello '.$GLOBALS['bhg']->user->getDisplayName().' welcome to the BHG Roster Administration Interface.</p>');

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

}

?>
