<?php

class page_starchart_site extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$site = bhg_starchart::getSite($id);

		$this->setTitle('Site :: '.$site->getName());

		$this->addBodyContent('<p>'.$site->getMisc().'</p>');

		$this->addSideMenu($GLOBALS['holonet']->starchart->getPlanetMenu($site->getPlanet()));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSystemMenu($site->getPlanet()->getSystem()));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

}

?>
