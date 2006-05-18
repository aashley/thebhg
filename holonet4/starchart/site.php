<?php

class page_starchart_site extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$site = bhg_starchart::getGroup($id);

		$this->setTitle('Site :: '.$site->getName());

		$this->addBodyContent('<p>'.$site->getDescription().'</p>');

		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

}

?>
