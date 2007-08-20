<?php

class page_roster_person extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		list($id) = $this->getTrailingElements();
		$person = bhg_roster::getPerson($id);

		$this->setTitle('Person :: '.$person->getName());

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildPersonal($person));
		$bar->addTab($this->buildOnline($person));
		$bar->addTab($this->buildMedals($person));
		$bar->addTab($this->buildCollege($person));
		$bar->addTab($this->buildArmour($person));
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
			$table->addRow(array(str_replace(' ', '&nbsp;', htmlspecialchars($submission->getDateCreated()->format('%B %e, %Y'))),
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
			
			$table->addRow(array(str_replace(' ', '&nbsp;', htmlspecialchars($award->getDateCreated()->format('%B %e, %Y'))),
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
						str_replace(' ', '&nbsp;', htmlspecialchars($event->getDateCreated()->getDate())),
						htmlspecialchars($event->toString()),
						));
		}

		$tab->addContent($table);
		return $tab;

	}

	private function buildOnline(bhg_roster_person $person) {

		$tab = new holonet_tab('online', 'Contact');
		$table = new HTML_Table(null, null, true);

		if (!$person->isDeleted())
			$table->addRow(array('E-mail&nbsp;Address:', str_replace(array('@', '.'), array(' [at] ', ' [dot] '), $person->getEmail())));

		if (strlen($homepage = $person->getURL()) > 0)
			$table->addRow(array('Home&nbsp;Page:', '<a href="'.htmlspecialchars($homepage).'">'.htmlspecialchars($homepage).'</a>'));

		if (strlen($aim = $person->getAIM()) > 0)
			$table->addRow(array('AIM&nbsp;Screen&nbsp;Name:', htmlspecialchars($aim)
						.' <a href="aim:GoIM?screenname='.htmlspecialchars($aim).'">'
						.'<img class="inline" src="http://api.oscar.aol.com/SOA/key=fr1Ko8PmeyVjPiv0/presence/'
						.htmlspecialchars($aim).'" border="0"/></a>'));

		if (strlen($icq = $person->getICQ()) > 0)
			$table->addRow(array('ICQ&nbsp;Number:', htmlspecialchars($icq)
						.' <img class="inline" src="http://status.icq.com/online.gif?icq='.htmlspecialchars($icq).'&img=5">'));

		if (strlen($nicks = $person->getIRCNicks()) > 0)
			$table->addRow(array('IRC&nbsp;Nicks:', htmlspecialchars($nicks)));

		if (strlen($jabber = $person->getJabber()) > 0)
			$table->addRow(array('Jabber&nbsp;ID:', htmlspecialchars($jabber)));

		if (strlen($msn = $person->getMSN()) > 0)
			$table->addRow(array('MSN&nbsp;Passport&nbsp;Name:', htmlspecialchars($msn)));

		if (strlen($yahoo = $person->getYahoo()) > 0)
			$table->addRow(array('Yahoo&nbsp;Messager&nbsp;ID:', htmlspecialchars($yahoo)));

		$tab->addContent($table);

		return $tab;

	}

	private function buildPersonal(bhg_roster_person $person) {

		$tab = new holonet_tab('personal', 'Dossier');
		$table = new HTML_Table(null, null, true);

		$table->addRow(array('ID&nbsp;Number:', $person->getID()));
		$table->addRow(array('Name:', htmlspecialchars($person->getName())));
		$table->addRow(array('Rank:', holonet::output($person->getRank())));
		$table->addRow(array('Position:', holonet::output($person->getPosition())));
		
		if ($person->inCadre()) {

			$cadre = holonet::output($person->getCadre());

			if ($person->getCadre()->getLeader()->isEqualTo($person))
				$cadre .= ' (Leader)';
			
			$table->addRow(array('Cadre:', $cadre));

		} else
			$table->addRow(array('Division:', holonet::output($person->getDivision())));

		if (strlen($quote = $person->getQuote()) > 0)
			$table->addRow(array('Quote:', '<i>'.htmlspecialchars($quote).'</i>'));

		if (!$person->isDeleted())
			$table->addRow(array('E-mail&nbsp;Address:', str_replace(array('@', '.'), array(' [at] ', ' [dot] '), $person->getEmail())));

		$table->addRow(array('Rank&nbsp;Credits:', holonet::formatCredits($person->getRankCredits())));
		$table->addRow(array('Account&nbsp;Balance:', holonet::formatCredits($person->getAccountBalance())));

		$joined = $person->getDateCreated();
		$timein = time() - $joined->getDate(DATE_FORMAT_UNIXTIME);
		$table->addRow(array('Time&nbsp;in&nbsp;the&nbsp;BHG:', holonet::formatDuration($timein)));
		$table->addRow(array('Join&nbsp;Date:', $joined->format('%A, %B %e, %Y')));
		
		try {

			$table->addRow(array('Last&nbsp;Promotion:', $person->getDateLastPromotion()->format('%A, %B %e, %Y')));

		} catch (bhg_not_found $e) {

			$table->addRow(array('Last&nbsp;Promotion:', $e->getMessage()));

		}

		$table->addRow(array('ID&nbsp;Line:', htmlspecialchars($person->getIDLine(true))));

		$tab->addContent($table);
		return $tab;
		
	}

}

?>
