<?php

class page_starchart_planet extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$planet = bhg_starchart::getGroup($id);

		$this->setTitle('Planet :: '.$planet->getName());

		$this->addBodyContent('<p>'.$planet->getDescription().'</p>');

		$sites = $planet->getSites();

		if ($sites->count() > 0) {

			$this->addBodyContent('<ul>');

			foreach ($sites as $site) {

				$this->addBodyContent('<li>'.holonet::output($site).'</li>');

			}

			$this->addBodyContent('</ul>');

		}

		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

}

?>
