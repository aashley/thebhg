<?php

include_once 'objects/holonet/tab/bar.php';

class page_starchart_default extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Star Chart');

		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildWelcome());
		$bar->addTab($GLOBALS['holonet']->starchart->buildSearch());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

	public function buildWelcome() {

		$tab = new holonet_tab('welcome', 'Welcome');

		$tab->addContent("<p>Welcome to the Star Chart.</p>");
		
		return $tab;

	}

}

?>
