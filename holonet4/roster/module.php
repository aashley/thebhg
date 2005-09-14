<?php

include_once 'objects/holonet/form.php';

class holonet_module_roster extends holonet_module {

	public function __construct() {

		parent::__construct('roster', 'Roster');

		$this->setMenu(new holonet_menu('roster/menu.xml'));

	}

	public function buildSearch() {

		$tab = new holonet_tab('search', 'Search');

		$form = new holonet_form(null, 'get', '/roster/search');

		$form->addElement('text',
											'for',
											'Search For:',
											array('size' => 20));

		$form->addElement('select',
											'in',
											'Search In:',
											array('id'       => 'ID Number',
														'name'     => 'Name',
														'email'    => 'E-mail Address',
														'irc'      => 'IRC Nick',
														'position' => 'Position',
														'rank'     => 'Rank'),
											array('size' => 1));

		$form->addElement('checkbox',
											'disavowed',
											'Include Disavowed:');

		$form->addButtons('Search');

		$form->addRule('for',
									 'A search term must be provided.',
									 'required');

		$form->addRule('in',
									 'A search context must be provided.',
									 'required');

		$tab->addContent($form);

		return $tab;

	}

	public function getDefaultPage($trail) {

		include_once 'roster/default.php';

		return new page_roster_default($trail);

	}

	public function getDivisionMenu() {

		$menu = new holonet_menu;
		$menu->title = 'Divisions';

		foreach ($GLOBALS['bhg']->roster->getDivisions() as $div)
			$menu->addItem(new holonet_menu_item($div->getName(), '/roster/division/'.$div->getID()));

		return $menu;

	}

}

?>
