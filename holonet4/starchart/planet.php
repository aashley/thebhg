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
		$bar->addTab($this->buildStats($planet));
		$bar->addTab($this->buildSites($planet));

		$this->addBodyContent($bar);

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

	public function buildStats($planet) {

		$tab = new holonet_tab('stats', 'Statistics');

		$table = new HTML_Table();

		$body = $table->getBody();

		$body->addRow(array('Name:', $planet->getName()));
		$body->addRow(array('Type:', $planet->getType()));
		$body->addRow(array('Temperature:', $planet->getTemperature()));
		$body->addRow(array('Atmosphere:', $planet->getAtmosphere()));
		$body->addRow(array('Hydrosphere:', $planet->getHydrosphere()));
		$body->addRow(array('Gravity:', $planet->getGravity()));
		$body->addRow(array('Terrain:', $planet->getTerrain()));
		$body->addRow(array('Day:', $planet->getDay()));
		$body->addRow(array('Year:', $planet->getYear()));
		$body->addRow(array('Species:', $planet->getSpecies()));
		$body->addRow(array('Starport:', $planet->getStarport()));
		$body->addRow(array('Population:', $planet->getPopulation()));
		$body->addRow(array('Technology:', $planet->getTechnology()));
		$body->addRow(array('Exports:', $planet->getExports()));
		$body->addRow(array('Imports:', $planet->getImports()));

		$tab->addContent($table);

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
