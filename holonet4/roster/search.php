<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_search extends holonet_page {

	public function buildPage() {

		$this->setTitle('Search');

		$bar = new holonet_tab_bar;
		$tab = new holonet_tab('results', 'Results');

		$disavowed = isset($_GET['disavowed']);

		switch ($_GET['in']) {

			case 'id':
				header('Location: /roster/person/'.$_GET['for']);
				return;
				
			case 'name':
			case 'email':
			case 'ircnicks':
				$people = $GLOBALS['bhg']->roster->getPeople(array($_GET['in'] => $_GET['for'], 'deleted' => $disavowed));
				break;

			case 'position':
				$pos = bhg_roster::getPosition($_GET['for']);
				$people = $GLOBALS['bhg']->roster->getPeople(array('position' => $pos, 'deleted' => $disavowed));
				break;

			case 'rank':
				$rank = bhg_roster::getRank($_GET['for']);
				$people = $GLOBALS['bhg']->roster->getPeople(array('rank' => $rank, 'deleted' => $disavowed));
				break;

			default:
				$tab->addContent('Invalid search parameters given.');
				return;

		}

		if ($people->count() == 0)
			$tab->addContent('No records matched the criteria given.');
		else
			$tab->addContent($GLOBALS['holonet']->roster->buildMemberTable($people, true));

		$bar->addTab($tab);
		$bar->addTab($GLOBALS['holonet']->roster->buildSearch());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

}

?>
