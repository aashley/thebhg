<?php

class page_starchart_site extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$site = bhg_starchart::getSite($id);

		$this->setTitle('Site :: '.$site->getName());

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildDescription($site));
		$bar->addTab($this->buildStats($site));

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->starchart->getPlanetMenu($site->getPlanet()));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSystemMenu($site->getPlanet()->getSystem()));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

	public function buildDescription(bhg_starchart_site $site) {

		$tab = new holonet_tab('description', 'Description');

		if (strlen($site->getPicture()) > 0)
			$tab->addContent('<img src="'.$site->getPicture().'" alt="Site Picture" style="float: left;" />');

		$tab->addContent('<p>'.$site->getDescription().'</p>');

		return $tab;

	}

	public function buildStats(bhg_starchart_site $site) {

		$tab = new holonet_tab('stats', 'Statistics');

		$table = new HTML_Table();

		$body = $table->getBody();

		$body->addRow(array('Name:', holonet::output($site)));
		$body->addRow(array('Owner:', holonet::output($site->getOwner())));
		$body->addRow(array('Location Type:', ucfirst($site->getSiteType())));
		$body->addRow(array('Location:', $site->getLocation()));
		$body->addRow(array('Type:', $site->getType()));
		$body->addRow(array('Arena Permitted:', ($site->isArena() ? 'Yes' : 'No')));

		$tab->addContent($body);

		return $tab;

	}

}

?>
