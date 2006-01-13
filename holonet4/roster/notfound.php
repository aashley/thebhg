<?php

class page_roster_notfound extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();

		$this->setTitle('Not Found');

		$this->addBodyContent('Your search for "'
												 .htmlspecialchars($trail[0])
												 .'" was in vain.');

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}
	
}

?>
