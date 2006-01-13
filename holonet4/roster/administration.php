<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_administration extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Roster');

		$this->addBodyContent('Hello '.$GLOBALS['bhg']->user->getDisplayName());
		//$this->addBodyContent('Test');

	}

	public function canAccessPage(bhg_roster_person $user) {

		return ($user->getID() == 94);

	}

}

?>
