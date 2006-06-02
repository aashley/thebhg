<?php

class page_starchart_view extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$object = bhg_starchart::getObject($id);

		$this->setTitle($object->getType()->getName().' :: '.$object->getName());

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildDescription($object));
		$bar->addTab($this->buildStats($object));
		$bar->addTab($this->buildSites($object));

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->starchart->getSideMenu());

	}

	public function buildDescription($object) {

		$tab = new holonet_tab('description', 'Description');

		$tab->addContent('<img src="'.$object->getPicture().'" alt="" style="float: left;" />');

		$tab->addContent('<p>'.$object->getDescription().'</p>');

		return $tab;

	}

	public function buildStats($object) {

		$tab = new holonet_tab('stats', 'Statistics');

		$table = new HTML_Table();

		$body = $table->getBody();

		$attributes = $object->getAttributes();

		foreach ($attributes as $attribute) {

			$body->addRow(array(
						htmlspecialchars($attribute->getType()->getName()),
						htmlspecialchars($attribute->getValue()),
						));

		}

		$tab->addContent($table);

		return $tab;

	}

	public function buildSites($object) {

		$tab = new holonet_tab('sites', 'Objects');

		$tab->addContent(holonet::buildList($object->getChildren()));

		return $tab;

	}

}

?>
