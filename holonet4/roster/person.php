<?php

class page_roster_person extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		list($id) = $this->getTrailingElements();
		$person = bhg_roster::getPerson($id);

		$this->setTitle('Person :: '.$person->getName());

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildPersonal($person));
		$bar->addTab($this->buildMedals($person));
		$bar->addTab($this->buildCollege($person));
		//$bar->addTab($this->buildArmour($person));
		$bar->addTab($this->buildHistory($person));

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	private function buildArmour(bhg_roster_person $person) {
		
		$tab = new holonet_tab('armour', 'Armour');

		$tab->addContent('<img src="http://holonet.thebhg.org/roster/armour/armour.php?id='
				.$person->getID()
				.'" alt="Armour for '
				.htmlspecialchars($person->getName())
				.'" />');
		
		return $tab;
		
	}

	private function buildCollege(bhg_roster_person $person) {

		$tab = new holonet_tab('college', 'College');
		$table = new HTML_Table(null, null, true);
		$submissions = $GLOBALS['bhg']->college->getSubmissions(array('submitter' => $person));
		$submissions->sort('getDateCreated', 'desc');

		$head = $table->getHeader();
		$head->addRow(array('Date', 'Course', 'Status', 'Score'), array(), 'TH');
		foreach ($submissions as $submission)
			$table->addRow(array(htmlspecialchars($submission->getDateCreated()->format('%B %e, %Y')),
					     htmlspecialchars($submission->getExam()->getName()),
					     $submission->getStatus(),
					     $submission->isGraded() ? number_format($submission->getScore()) : 'N/A'));

		$tab->addContent($table);
		return $tab;
		
	}

	private function buildMedals(bhg_roster_person $person) {

		$tab = new holonet_tab('medals', 'Medals');
		$table = new HTML_Table(null, null, true);
		$medals = $person->getMedals();
		$medals->sort('getDateCreated', 'desc');
		
		$head = $table->getHeader();
		$head->addRow(array('Date', 'Awarded By', 'Medal'), array(), 'TH');
		foreach ($medals as $award) {
			$reason = holonet::output($award->getMedal());

			if (strlen($why = $award->getReason()) > 0) {
				$reason .= ' for '.htmlspecialchars($award->getReason());
				if (substr($reason, -1) != '.')
					$reason .= '.';
			}
			
			$table->addRow(array(htmlspecialchars($award->getDateCreated()->format('%B %e, %Y')),
					     holonet::output($award->getAwarder()),
					     $reason));
		}

		$tab->addContent($table);
		return $tab;
		
	}

	private function buildHistory(bhg_roster_person $person) {

		$tab = new holonet_tab('history', 'Recent History');
		$table = new HTML_Table(null, null, true);
		$events = $person->getHistory(array('limit' => 30));

		$head = $table->getHeader();
		$head->addRow(array('Date', 'Event'), array(), 'TH');
		foreach ($events as $event) {
			$table->addRow(array(
						htmlspecialchars($event->getDateCreated()->getDate()),
						htmlspecialchars($event->toString()),
						));
		}

		$tab->addContent($table);
		return $tab;

	}

	private function buildPersonal(bhg_roster_person $person) {

		$tab = new holonet_tab('personal', 'Dossier');
		$table = new HTML_Table(null, null, true);

		$table->addRow(array('ID Number:', $person->getID()));
		$table->addRow(array('Name:', htmlspecialchars($person->getName())));
		$table->addRow(array('Rank:', holonet::output($person->getRank())));
		$table->addRow(array('Position:', holonet::output($person->getPosition())));
		$table->addRow(array('Division:', holonet::output($person->getDivision())));
		
		if ($person->inCadre()) {

			$cadre = holonet::output($person->getCadre());

			if ($person->getCadre()->getLeader()->isEqualTo($person))
				$cadre .= ' (Leader)';
			
			$table->addRow(array('Cadre:', $cadre));

		}

		if (strlen($quote = $person->getQuote()) > 0)
			$table->addRow(array('Quote:', '<i>'.htmlspecialchars($quote).'</i>'));

		if (!$person->isDeleted())
			$table->addRow(array('E-mail Address:', str_replace(array('@', '.'), array(' [at] ', ' [dot] '), $person->getEmail())));

		if (strlen($homepage = $person->getURL()) > 0)
			$table->addRow(array('Home Page:', '<a href="'.htmlspecialchars($homepage).'">'.htmlspecialchars($homepage).'</a>'));

		if (strlen($nicks = $person->getIRCNicks()) > 0)
			$table->addRow(array('IRC Nicks:', htmlspecialchars($nicks)));

		$table->addRow(array('Rank Credits:', holonet::formatCredits($person->getRankCredits())));
		$table->addRow(array('Account Balance:', holonet::formatCredits($person->getAccountBalance())));

		$joined = $person->getDateCreated();
		$timein = time() - $joined->getDate(DATE_FORMAT_UNIXTIME);
		$table->addRow(array('Time in the BHG:', holonet::formatDuration($timein)));
		$table->addRow(array('Join Date:', $joined->format('%A, %B %e, %Y')));

		// XXX Implement last promotion code here, once we have object support.

		$table->addRow(array('ID Line:', htmlspecialchars($person->getIDLine(true))));

		$tab->addContent($table);
		return $tab;
		
	}

}

?>
