<?php

class page_starchart_system extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$system = bhg_starchart::getSystem($id);

		$this->setTitle('System :: '.$system->getName());

		$this->addBodyContent('<p>'.$system->getDescription().'</p>');

		$planets = $system->getPlanets();

		if ($planets->count() > 0) {

			$this->addBodyContent('<ul>');

			foreach ($planets as $planet) {

				$this->addBodyContent('<li>'.holonet::output($planet).'</li>');

			}

			$this->addBodyContent('</ul>');

		}

		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

}

?>
