<?php

class holonet_module_roster extends holonet_module {

	public function __construct() {

		parent::__construct('roster', 'Roster');

		$this->setMenu(new holonet_menu('roster/menu.xml'));

	}

	public function buildMemberTable(bhg_core_list $members, $showDivisions = false) {

		$table = new HTML_Table;

		$headings = array('Position',
											'Rank',
											'Name',
											'Rank Credits',
											'Account Balance');

		$head = $table->getHeader();
		$body = $table->getBody();

		if ($showDivisions)
			array_unshift($headings, 'Division');

		$head->addRow($headings, array(), 'TH');

		foreach ($members as $member) {

			$row = array(holonet::output($member->getPosition()),
									 holonet::output($member->getRank()),
									 holonet::output($member),
									 number_format($member->getRankCredits()),
									 number_format($member->getAccountBalance()));

			if ($showDivisions)
				array_unshift($row, holonet::output($member->getDivision()));

			$body->addRow($row);

		}

		return $table;

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
														'ircnicks' => 'IRC Nick',
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

		$defaults = array();
		if (isset($_GET['for']))
			$defaults['for'] = $_GET['for'];
		if (isset($_GET['in']))
			$defaults['in'] = $_GET['in'];
		if (isset($_GET['disavowed']))
			$defaults['disavowed'] = $_GET['disavowed'];
		$form->setDefaults($defaults);

		$tab->addContent($form);

		return $tab;

	}

	public function getDefaultPage($trail) {

		// TODO: Search on trail for a user and redirect to a person page,
		// disambig, or not found.

		// Don't search.
		if (count($trail) == 0
		 || $trail[0] == 'roster') {
			
			include_once 'roster/default.php';
			return new page_roster_default($trail);

		}

		// Search for a user.

		if (is_numeric($trail[0])) {

			include_once './roster/person.php';
			return new page_roster_person($trail);
			
		}

		// This breaks the URL spec, as + only has meaning within a GET parameter,
		// but it's (a) useful, and (b) somewhat expected.
		$trail[0] = str_replace('+', ' ', $trail[0]);
		
		$people = $GLOBALS['bhg']->roster->getPeople(array('name' => $trail[0]));

		if ($people->count() == 0) {

			include_once 'roster/notfound.php';
			return new page_roster_notfound($trail);

		} elseif ($people->count() == 1) {

			include_once './roster/person.php';
			return new page_roster_person(array($people->getItem(0)->getID()));
			
		} else {

			include_once 'roster/disambig.php';
			$trail[] = $people;
			return new page_roster_disambig($trail);

		}

	}

	public function getDivisionMenu() {

		$menus = array();

		foreach ($GLOBALS['bhg']->roster->getDivisionCategories() as $category) {
			
			$menu = new holonet_menu;
			$menu->title = $category->getName();
			
			foreach ($category->getDivisions() as $div)
				$menu->addItem(new holonet_menu_item($div->getName(), '/roster/division/'.$div->getID()));

			$menus[] = $menu;

		}

		return $menus;

	}

	public function getAdministrationPermissions($user) {

		$parts = array(
				'underlord' 		=> false,
				'commission'		=> false,
				'judicator'			=> false,
				'chief'					=> false,
				'warden'				=> false,
				'cs'						=> false,
				'sysadmin'			=> false,
				);

		if (	 $user->getPosition()->isEqualTo($GLOBALS['bhg']->roster->getPosition(2))
				|| in_array($user->getID(), $GLOBALS['gods'])) {

			foreach ($parts as $key => $value) {
				$parts[$key] = true;
			}

		} else {

			if ($user->getDivision()->isEqualTo($GLOBALS['bhg']->roster->getDivision(10))) {

				$parts['commission'] = true;

			}

			if ($user->getPosition()->isEqualTo($GLOBALS['bhg']->roster->getPosition(6))) {

				$parts['judicator'] = true;

			} elseif (	 $user->getPosition()->isEqualTo($GLOBALS['bhg']->roster->getPosition(9))
								|| $user->getPosition()->isEqualTo($GLOBALS['bhg']->roster->getPosition(29))) {

				$parts['cs'] = true;

			} elseif ($user->getPosition()->isEqualTo($GLOBALS['bhg']->roster->getPosition(11))) {

				$parts['chief'] = true;

			} elseif ($user->getPosition()->isEqualTo($GLOBALS['bhg']->roster->getPosition(10))) {

				$parts['warden'] = true;

			}

		}

		return $parts;

	}

	public function getAdministrationMenu() {

		$user = $GLOBALS['bhg']->user;

		$perms = $this->getAdministrationPermissions($user);

		$menus = array();

		$menu = new holonet_menu;
		$menu->title = 'Personal Details';
		$menu->addItem(new holonet_menu_item('My Account', '/roster/administration/my'));
		$menu->addItem(new holonet_menu_item('Request Transfer', '/roster/administration/my/transfer'));
		$menus[] = $menu;

		if (	 $perms['commission']
				|| $perms['chief']
				|| $perms['warden']) {

			$menu = new holonet_menu;
			$menu->title = 'Awards';
			if ($perms['underlord'])
				$menu->addItem(new holonet_menu_item('Approve Awards', '/roster/administration/award/approve'));
			$menu->addItem(new holonet_menu_item('Award Credits', '/roster/administration/award/credits'));
			$menu->addItem(new holonet_menu_item('Award Medals', '/roster/administration/award/medals'));

			$menus[] = $menu;

		}

		if (	 $perms['underlord']
				|| $perms['chief']
				|| $perms['warden']) {

			$menu = new holonet_menu;
			$menu->title = 'Membership';
			if ($perms['underlord']) {
				$menu->addItem(new holonet_menu_item('Approve Transfers', '/roster/administration/members/transfers'));
				$menu->addItem(new holonet_menu_item('Reassign Members', '/roster/administration/members/reassign'));
				$menu->addItem(new holonet_menu_item('Manage AWOLs', '/roster/administration/members/manageawol'));
				$menu->addItem(new holonet_menu_item('Edit Member', '/roster/administration/members/edit'));
			}
			$menu->addItem(new holonet_menu_item('Declare AWOLs', '/roster/administration/members/awol'));

			$menus[] = $menu;

		}

		if ($perms['sysadmin']) {

			$menu = new holonet_menu;
			$menu->title = 'System Administration';
			$menu->addItem(new holonet_menu_item('Manage Categories', '/roster/administration/system/category'));
			$menu->addItem(new holonet_menu_item('Manage Divisions', '/roster/administration/system/division'));
			$menu->addItem(new holonet_menu_item('Manage Positions', '/roster/administration/system/position'));
			$menu->addItem(new holonet_menu_item('Manage Ranks', '/roster/administration/system/rank'));

			$menus[] = $menu;

		}

		return $menus;

	}

}

?>
