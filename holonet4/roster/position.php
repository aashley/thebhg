<?php

class page_roster_position extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$position = bhg_roster::getPosition($id);

		$this->setTitle('Position :: '.$position->getName());

		$tabbar = new holonet_tab_bar;

		$tabbar->addTab($this->buildInformation($position));

		$this->addBodyContent($tabbar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	private function buildInformation(bhg_roster_position $position) {

		$tab = new holonet_tab('info', 'Information');

		$table = new HTML_Table(null, null, true);

		$body = $table->getBody();

		$body->addRow(array('Name:', htmlspecialchars($position->getName())));
		$body->addRow(array('Abbreviation:', htmlspecialchars($position->getAbbrev())));
		$body->addRow(array('Monthly Income:', number_format($position->getIncome())));

		$tab->addContent($table);

		return $tab;

	}

}

?>
