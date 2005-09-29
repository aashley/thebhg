<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_person extends holonet_page {

	public function buildPage() {

		list($id) = $this->getTrailingElements();
		$person = bhg_roster::getPerson($id);

		$this->setTitle('Person :: '.$person->getName());

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildPersonal($person));

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	private function buildPersonal(bhg_roster_person $person) {

		$tab = new holonet_tab('personal', 'Basic Information');
		$table = new HTML_Table;

		$table->addRow(array('ID Number:', $person->getID()));
		$table->addRow(array('Name:', htmlspecialchars($person->getName())));
		$table->addRow(array('Rank:', $GLOBALS['holonet']->roster->output($person->getRank())));
		$table->addRow(array('Position:', $GLOBALS['holonet']->roster->output($person->getPosition())));
		$table->addRow(array('Division:', $GLOBALS['holonet']->roster->output($person->getDivision())));
		
		if ($person->inCadre())
			$table->addRow(array('Cadre:', $GLOBALS['holonet']->roster->output($person->getCadre())));

		if (strlen($quote = $person->getQuote()) > 0)
			$table->addRow(array('Quote:', '<i>'.htmlspecialchars($quote).'</i>'));

		if (!$person->isDeleted())
			$table->addRow(array('E-mail Address:', str_replace(array('@', '.'), array(' [at] ', ' [dot] '), $person->getEmail())));

		if (strlen($homepage = $person->getURL()) > 0)
			$table->addRow(array('Home Page:', '<a href="'.htmlspecialchars($homepage).'">'.htmlspecialchars($homepage).'</a>'));

		if (strlen($nicks = $person->getIRCNicks()) > 0)
			$table->addRow(array('IRC Nicks:', htmlspecialchars($nicks)));

		$table->addRow(array('Rank Credits:', $GLOBALS['holonet']->roster->formatCredits($person->getRankCredits())));
		$table->addRow(array('Account Balance:', $GLOBALS['holonet']->roster->formatCredits($person->getAccountBalance())));

		$joined = $person->getDateCreated();
		$timein = time() - $joined->getDate(DATE_FORMAT_UNIXTIME);
		$table->addRow(array('Time in the BHG:', $GLOBALS['holonet']->roster->formatDuration($timein)));
		$table->addRow(array('Join Date:', $joined->format('%A, %B %e, %Y')));

		// XXX Implement last promotion code here, once we have object support.

		$table->addRow(array('ID Line:', htmlspecialchars($person->getIDLine(true))));

		$tab->addContent($table);
		return $tab;
		
	}

}

?>
