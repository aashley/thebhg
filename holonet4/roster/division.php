<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_division extends holonet_page {

	public function buildPage() {

		list($id) = $this->getTrailingElements();
		$div = bhg_roster::getDivision($id);

		if ($div->isKabal())
			$div = bhg_roster::getKabal($id);

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

		$table = new HTML_Table(null, null, true);

		$body = $table->getBody();

		$body->addRow(array('Mailing List:',
												'<a href="mailto:'
												.urlencode($div->getMailingList())
												.'@thebhg.org">'
												.htmlspecialchars($div->getMailingList())
												.' at thebhg.org</a>'));

		if ($div->isKabal()) {
			
			try {

				$chief = $div->getChief();
	
				$body->addRow(array(
							'Chief:',
							'<a href="/roster/person/'.$chief->getID().'">'.$chief->getDisplayName().'</a>',
							));

			} catch (bhg_list_exception_notfound $e) {

				$body->addRow(array(
							'Chief:', 'N/A'
							));

			}

			try {

				$cra = $div->getChief();

				$body->addRow(array(
							'CRA:',
							'<a href="/roster/person/'.$cra->getID().'">'.$cra->getDisplayName().'</a>',
							));

			} catch (bhg_list_exception_notfound $e) {

				$body->addRow(array(
							'CRA:', 'N/A'
							));

			}

		}

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
