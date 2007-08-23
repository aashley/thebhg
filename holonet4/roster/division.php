<?php

class page_roster_division extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		list($id) = $this->getTrailingElements();
		$div = bhg_roster::getDivision($id);

		$title = 'Division';
		$sort = array(array('getPosition', 'getSortOrder'), 'getRankCredits', 'getName');
		$by = array('asc', 'desc', 'asc');
		
		if ($div->isCadre()){
			$div = bhg_roster::getCadre($id);
			$title = 'Cadre';	
			$sort = array(array('getCadreRank', 'getSortOrder'), 'getRankCredits', 'getName');
			$by = array('asc', 'desc', 'asc');
		}

		$this->setTitle($title . ' :: '.$div->getName());

		$tabbar = new holonet_tab_bar;

		$people = $div->getPeople();
		$people->multisort($sort, $by);

		$tabbar->addTab($this->buildMembers($people));
		$tabbar->addTab($this->buildInformation($div));
		IF ($div->isCadre())
			$tabbar->addTab($this->buildBank($div));

		$this->addBodyContent($tabbar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	private function buildInformation($div) {

		$tab = new holonet_tab('info', 'Information');

		$table = new HTML_Table(null, null, true);

		$body = $table->getBody();

		if ($div->getMailingList() != 'none')
			$body->addRow(array('Mailing List:',
													'<a href="mailto:'
													.urlencode($div->getMailingList())
													.'@thebhg.org">'
													.htmlspecialchars($div->getMailingList())
													.' at thebhg.org</a>'));

		if ($div->isCadre()) {
			
			try {

				$leader = $div->getLeader();
	
				$body->addRow(array(
							'Leader:',
							holonet::output($leader),
							));

			} catch (bhg_list_exception_notfound $e) {

				$body->addRow(array(
							'Leader:', 'N/A'
							));

			}

			if (strlen($div->getHomePageURL()))
				$body->addRow(array(
							'Home Page:',
							'<a href="'.htmlspecialchars($div->getHomePageURL()).'">'.htmlspecialchars($div->getHomePageURL()).'</a>',
							));

			$body->addRow(array(
						'Slogan:',
						htmlspecialchars($div->getSlogan()),
						));
						
			$body->addRow(array(
						'Bank Balance:',
						holonet::formatCredits($div->getAccountBalance()),
						));

		}

		$tab->addContent($table);

		return $tab;

	}

	private function buildMembers(bhg_core_list $members) {

		$tab = new holonet_tab('members', 'Members');

		$tab->addContent($GLOBALS['holonet']->roster->buildMemberTable($members, false));

		return $tab;

	}
	
	private function buildBank($div) {

		$tab = new holonet_tab('bank_history', 'Recent Bank Transactions');
		$table = new HTML_Table(null, null, true);
		$events = $div->getBankHistory(array('limit' => 30));

		$head = $table->getHeader();
		$head->addRow(array('Date', 'Event'), array(), 'TH');
		foreach ($events as $event) {
			$table->addRow(array(
						str_replace(' ', '&nbsp;', htmlspecialchars($event->getDateCreated()->getDate())),
						htmlspecialchars($event->toString()),
						));
		}

		$tab->addContent($table);
		return $tab;

	}

}

?>
