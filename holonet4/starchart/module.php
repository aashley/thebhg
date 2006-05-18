<?php

include_once 'HTML/Table.php';
include_once 'objects/holonet/form.php';

class holonet_module_starchart extends holonet_module {

	public function __construct() {

		parent::__construct('starchart', 'Medal Board');

		$this->setMenu(new holonet_menu('starchart/menu.xml'));

	}

	public function getDefaultPage($trail) {

		include_once 'starchart/default.php';
		return new page_starchart_default($trail);

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
