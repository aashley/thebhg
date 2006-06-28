<?php

class page_roster_rank extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$rank = bhg_roster::getRank($id);

		$this->setTitle('Rank :: '.$rank->getName());

		$tabbar = new holonet_tab_bar;

		$tabbar->addTab($this->buildInformation($rank));

		$this->addBodyContent($tabbar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	private function buildInformation(bhg_roster_rank $rank) {

		$tab = new holonet_tab('info', 'Information');

		$table = new HTML_Table(null, null, true);

		$body = $table->getBody();

		$body->addRow(array('Name:', htmlspecialchars($rank->getName())));
		$body->addRow(array('Abbreviation:', htmlspecialchars($rank->getAbbrev())));
		$body->addRow(array('Required Credits:', $rank->getUnlimitedCredits() ? 'N/A' : number_format($rank->getRequiredCredits())));

		$tab->addContent($table);

		return $tab;

	}

}

?>
