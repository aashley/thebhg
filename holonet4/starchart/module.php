<?php

class holonet_module_starchart extends holonet_module {

	public function __construct() {

		parent::__construct('starchart', 'Star Chart');

		$this->setMenu(new holonet_menu('starchart/menu.xml'));

	}

	public function getDefaultPage($trail) {

		if (	 count($trail) == 0
				|| $trail[0] == 'starchart') {

			include_once 'starchart/default.php';
			return new page_starchart_default($trail);

		}

		// This breaks the URL spec, as + only has meaning within a GET parameter,
		// but it's (a) useful, and (b) somewhat expected.
		$trail[0] = str_replace('+', ' ', $trail[0]);

		$systems = $GLOBALS['bhg']->starchart->getSystems(array('name' => $trail[0]));
		$planets = $GLOBALS['bhg']->starchart->getPlanets(array('name' => $trail[0]));
		$sites = $GLOBALS['bhg']->starchart->getSites(array('name' => $trail[0]));

		if (	 $systems->count() == 0
				&& $planets->count() == 0
				&& $sites->count() == 0) {

			include_once 'starchart/notfound.php';
			return new page_starchart_notfound($trail);

		} elseif (	 $systems->count() == 1
							&& $planets->count() == 0
							&& $sites->count() == 0) {

			include_once 'starchart/system.php';
			return new page_starchart_system(array($systems->getItem(0)->getID()));

		} elseif (	 $systems->count() == 0
							&& $planets->count() == 1
							&& $sites->count() == 0) {

			include_once 'starchart/planet.php';
			return new page_starchart_planet(array($planets->getItem(0)->getID()));

		} elseif (	 $systems->count() == 0
							&& $planets->count() == 0
							&& $sites->count() == 1) {

			include_once 'starchart/site.php';
			return new page_starchart_site(array($sites->getItem(0)->getID()));

		} else {

			include_once 'starchart/disambig.php';
			$trail[] = $systems;
			$trail[] = $planets;
			$trail[] = $sites;
			return new page_startchart_disambig($trail);

		}

	}

	public function getSideMenu() {

		$menus = array();

		$menu = new holonet_menu;
		$menu->title = 'Systems';

		foreach ($GLOBALS['bhg']->starchart->getSystems() as $system) {
			
			$menu->addItem(new holonet_menu_item($system->getName(), '/starchart/system/'.$system->getID()));

		}

		$menus[] = $menu;

		return $menus;

	}

	public function getSystemMenu(bhg_starchart_system $system) {

		$menus = array();

		$menu = new holonet_menu;
		$menu->title = $system->getName();

		foreach ($system->getPlanets() as $planet) {

			$menu->addItem(new holonet_menu_item($planet->getName(), '/starchart/planet/'.$planet->getID()));

		}

		$menus[] = $menu;

		return $menus;

	}

	public function getPlanetMenu(bhg_starchart_planet $planet) {

		$menus = array();

		$menu = new holonet_menu;
		$menu->title = $planet->getName();

		foreach ($planet->getSites() as $site) {

			$menu->addItem(new holonet_menu_item($site->getName(), '/starchart/site/'.$planet->getID()));

		}

		$menus[] = $menu;

		return $menus;

	}

	public function buildSearch() {

		$tab = new holonet_tab('search', 'Search');

		$form = new holonet_form(null, 'get', '/starchart/search');

		$form->addElement('text',
											'for',
											'Search For:',
											array('size' => 20));

		$form->addElement('select',
											'in',
											'Search In:',
											array(
												'system'	=> 'Systems',
												'planet'	=> 'Planets',
												'site'		=> 'Sites',
												),
											array(
												'size' 			=> 3,
												'multiple'	=> 'multiple',
												)
											);

		$form->addButtons('Search');

		$form->addRule('for',
									 'A search term must be provided.',
									 'required');

		$form->addRule('in',
									 'A search context must be provided.',
									 'required');

		$defaults = array();
		if (isset($_GET['for']))
			$defaults['for'] = $_GET['for'];
		if (isset($_GET['in']))
			$defaults['in'] = $_GET['in'];
		$form->setDefaults($defaults);

		$tab->addContent($form);

		return $tab;

	}

}

?>
