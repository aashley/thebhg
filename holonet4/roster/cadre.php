<?php

class page_roster_cadre extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		list($id) = $this->getTrailingElements();
		$cadre = bhg_roster::getCadre($id);

		$this->setTitle('Cadre :: '.$cadre->getName());

		$tabbar = new holonet_tab_bar;

		$people = $cadre->getPeople();
		$people->multisort(array(array('getPosition', 'getSortOrder'), 'getRankCredits', 'getName'), array('asc', 'desc', 'asc'));

		$tabbar->addTab($this->buildMembers($people));
		$tabbar->addTab($this->buildInformation($cadre));

		$this->addBodyContent($tabbar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getCadreMenu());

	}

	private function buildInformation(bhg_roster_cadre $cadre) {

		$tab = new holonet_tab('info', 'Information');

		$table = new HTML_Table(null, null, true);

		$body = $table->getBody();

		$leader = $cadre->getLeader();

		$body->addRow(array(
					'Cadre Leader:',
					holonet::output($leader),
					));

		$body->addRow(array(
					'Home Page:',
					'<a href="'.htmlspecialchars($cadre->getHomePage()).'">'.htmlspecialchars($cadre->getHomePage()).'</a>',
					));

		$body->addRow(array(
					'Slogan:',
					htmlspecialchars($cadre->getSlogan()),
					));

		$tab->addContent($table);

		return $tab;

	}

	private function buildMembers(bhg_core_list $members) {

		$tab = new holonet_tab('members', 'Members');

		$tab->addContent($GLOBALS['holonet']->roster->buildMemberTable($members, false));

		return $tab;

	}

}

?>
