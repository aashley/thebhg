<?php

include_once 'objects/holonet/tab/bar.php';

class page_library_default extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Library');

		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildWelcome());

		$shelves = $GLOBALS['bhg']->library->getShelves();

		if ($shelves->count() > 0) {

			foreach ($shelves as $shelf) {

				$bar->addTab($GLOBALS['holonet']->library->buildShelfTab());

			}

		}

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holodeck']->library->getBookMenu());

	}

	public function buildWelcome() {

		$tab = new holonet_tab('welcome', 'Welcome');

		$tab->addContent("<p>Taking a deep breath, you step into the BHG Library, "
				."itself a part of the Citadel complex on Sol'Rahl. Immediately, you "
				."notice the sheer scale of the place. The Library is massive, with "
				."high vaulted ceilings and rows upon rows of bookshelves. You know "
				."that within these walls, you can find information on almost anything "
				."you need to, from the structure of the BHG Commission to the mating "
				."habits of lawn gnomes.</p>");
		
		$tab->addContent("<p>You sit down at the nearest catalogue terminal and "
				."start typing in your request, secure in the knowledge that the "
				."answers you seek are somewhere within this building...</p>");

		return $tab;

	}

}

?>
