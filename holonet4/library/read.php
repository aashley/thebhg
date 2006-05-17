<?php

class page_library_read extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		list($obj) = $this->getTrailingElements();

		if ($obj instanceof bhg_roster_book) {

			$this->addBodyContent('<p>Render book.</p>');

		} elseif ($obj instanceof bhg_roster_chapter) {

			$this->addBodyContent('<p>Render chapter.</p>');

		}

		$this->addSideMenu($GLOBALS['holonet']->library->getBookMenu());

	}

}

?>
