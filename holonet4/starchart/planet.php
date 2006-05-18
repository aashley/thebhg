<?php

class page_starchart_planet extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$planet = bhg_starchart::getPlanet($id);

		$this->setTitle('Planet :: '.$planet->getName());

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildDescription($planet));
		$bar->addTab($this->buildSites($planet));

		$this->addSideMenu($GLOBALS['holonet']->starchart->getPlanetMenu($planet));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSystemMenu($planet->getSystem()));
		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

	public function buildDescription($planet) {

		$tab = new holonet_tab('description', 'Description');

		$tab->addContent('<img src="http://lyarna.thebhg.org/planets/images/'.$planet->getPicture().'" alt="" style="float: left;" />');

		$tab->addContent('<p>'.$planet->getMisc().'</p>');

		return $tab;

	}

	public function buildSites($planet) {

		$tab = new holonet_tab('sites', 'Sites');

		$sites = $planet->getSites();

		if ($sites->count() > 0) {

			$tab->addContent('<ul>');

			foreach ($sites as $site) {

				$tab->addContent('<li>'.holonet::output($site).'</li>');

			}

			$tab->addContent('</ul>');

		}

		return $tab;

	}

}

?>
