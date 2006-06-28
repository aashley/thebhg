<?php

class page_roster_cadres extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Cadres');

		$this->addBodyContent('<p>Please choose from the cadres at right.</p>');

		$this->addSideMenu($GLOBALS['holonet']->roster->getCadreMenu());

	}

}

?>
