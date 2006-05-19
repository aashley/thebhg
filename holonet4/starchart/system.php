<?php

class page_starchart_system extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$system = bhg_starchart::getSystem($id);

		$this->setTitle('System :: '.$system->getName());

		$this->addBodyContent('<p>'.$system->getDescription().'</p>');

		$this->addBodyContent(holonet::buildList($system->getPlanets()));

		$this->addSideMenu($GLOBALS['holonet']->starchart->getSystemMenu($system));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

}

?>
