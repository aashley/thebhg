<?php

include_once 'HTML/Table.php';
include_once 'objects/holonet/form.php';

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

		if ($showDivisions)
			array_unshift($headings, 'Division');

		$table->addRow($headings, array(), 'TH');

		foreach ($members as $member) {

			$row = array($this->output($member->getPosition()),
									 $this->output($member->getRank()),
									 $this->output($member),
									 number_format($member->getRankCredits()),
									 number_format($member->getAccountBalance()));

			if ($showDivisions)
				array_unshift($row, $this->output($member->getDivision()));

			$table->addRow($row);

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

		$menu = new holonet_menu;
		$menu->title = 'Divisions';

		foreach ($GLOBALS['bhg']->roster->getDivisions() as $div)
			$menu->addItem(new holonet_menu_item($div->getName(), '/roster/division/'.$div->getID()));

		return $menu;

	}

	static public function formatCredits($amount) {
		return self::pluralise('IC', $amount);
	}

	static public function formatDuration($seconds) {
		$then = time() - $seconds;

		$anniv = mktime(0, 0, 0, date('m', $then), date('d', $then), date('Y'));
		if ($anniv > time()) {
			$years = date('Y') - date('Y', $then) - 1;
		}
		else {
			$years = date('Y') - date('Y', $then);
		}
		
		$days = date('z') - date('z', $then);
		if (date('L', $then) == 1
		 && date('L') == 0
		 && date('z') > 60)
			$days++;
		if ($days < 0) {
			$days += (date('L', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 1)) ? 366 : 365);
		}

		$weeks = floor($days / 7);
		$days %= 7;

		$seconds %= 86400;
		$hours = floor($seconds / 3600);
		$seconds %= 3600;
		$minutes = floor($seconds / 60);
		$seconds %= 60;

		if ($days) {
			$bits[] = self::pluralise('day', $days);
		}
		if ($weeks) {
			$bits[] = self::pluralise('week', $weeks);
		}
		if ($years) {
			$bits[] = self::pluralise('year', $years);
		}
		
		if (count($bits)) {
			$bits = array_reverse($bits, true);
			if (count($bits) > 2) {
				$last = $bits[0];
				unset($bits[0]);
				$str = implode(', ', $bits);
				$str .= ' and ' . $last;
			}
			else {
				$str = implode(' and ', $bits);
			}
		}
		else {
			$str = '0';
		}

		return $str;
	}

	public function output(bhg_core_base $obj) {

		if ($obj instanceof bhg_roster_cadre) {

			return '<a href="/roster/cadre/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_division) {

			return '<a href="/roster/division/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_person) {

			return '<a href="/roster/person/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_position) {

			return '<a href="/roster/position/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_rank) {

			return '<a href="/roster/rank/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif (method_exists($obj, 'getName')) {

			return htmlspecialchars($obj->getName());

		} else {

			return (string) $obj;

		}

	}

	static public function pluralise($name, $amount) {

		$amount = number_format($amount);

		if ($amount != '1')
			return "$amount {$name}s";
		else
			return "$amount $name";

	}
	
}

?>
