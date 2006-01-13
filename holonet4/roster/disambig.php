<?php

class page_roster_disambig extends holonet_page {
	
	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$search = $trail[0];
		$people = array_pop($trail);

		if (!$people instanceof bhg_core_list) {

			$this->setTitle('Error');
			$this->addBodyContent('This is not the page you are looking for. Move along.');
			return;

		}

		$this->setTitle('Multiple Records Found');

		$this->addBodyContent('<p>Your search for "'
												 .htmlspecialchars($search)
												 .'" returned '
												 .number_format($people->count())
												 .' match'
												 .($people->count() != 1 ? 'es' : '')
												 .'.</p>');

		$this->addBodyContent($GLOBALS['holonet']->roster->buildMemberTable($people, true));

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

}

?>
