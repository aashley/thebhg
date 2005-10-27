<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_division extends holonet_page {

	public function buildPage() {

		list($id) = $this->getTrailingElements();
		$div = bhg_roster::getDivision($id);

		$this->setTitle('Division :: '.$div->getName());

		$tabbar = new holonet_tab_bar;

		$people = $div->getPeople();
		$people->multisort(array(array('getPosition', 'getSortOrder'), 'getRankCredits', 'getName'), array('asc', 'desc', 'asc'));

		$tabbar->addTab($this->buildMembers($people));
		$tabbar->addTab($this->buildInformation($div));

		$this->addBodyContent($tabbar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	private function buildInformation(bhg_roster_division $div) {

		$tab = new holonet_tab('info', 'Information');

		$table = new HTML_Table;

		$body = $table->getBody();

		$body->addRow(array('Mailing List:',
												'<a href="mailto:'
												.urlencode($div->getMailingList())
												.'@thebhg.org">'
												.htmlspecialchars($div->getMailingList())
												.' at thebhg.org</a>'));

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
