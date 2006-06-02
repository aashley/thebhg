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

		if (is_numeric($trail[0])) {

			include_once 'starchart/view.php';
			return new page_starchart_view(array($trail[0]));

		}

		// This breaks the URL spec, as + only has meaning within a GET parameter,
		// but it's (a) useful, and (b) somewhat expected.
		$trail[0] = str_replace('+', ' ', $trail[0]);

		$objects = $GLOBALS['bhg']->starchart->getObjects(array('name' => $trail[0]));

		if ($objects->count() == 0) {

			include_once 'starchart/notfound.php';
			return new page_starchart_notfound($trail);

		} elseif ($objects->count() == 1) {

			include_once './starchart/view.php';
			return new page_starchart_view(array($objects->getItem(0)->getID()));

		} else {

			include_once 'starchart/disambig.php';
			$trail[] = $objects;
			return new page_starchart_disambig($trail);

		}

	}

	public function getSideMenu() {

		$menus = array();

		$menu = new holonet_menu;
		$menu->title = 'Global Items';

		foreach ($GLOBALS['bhg']->starchart->getObjects() as $object) {
			
			$menu->addItem(new holonet_menu_item($object->getName(), '/starchart/'.$object->getID()));

		}

		$menus[] = $menu;

		return $menus;

	}

	public function getObjectMenu(bhg_starchart_object $object) {

		$menus = array();

		$menu = new holonet_menu;
		$menu->title = $object->getName();

		foreach ($object->getChildren() as $child) {

			$menu->addItem(new holonet_menu_item($child->getName(), '/starchart/'.$child->getID()));

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

		$form->addButtons('Search');

		$form->addRule('for',
									 'A search term must be provided.',
									 'required');

		$defaults = array();
		if (isset($_GET['for']))
			$defaults['for'] = $_GET['for'];
		$form->setDefaults($defaults);

		$tab->addContent($form);

		return $tab;

	}

}

?>
