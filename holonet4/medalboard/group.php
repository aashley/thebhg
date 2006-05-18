<?php

class page_medalboard_group extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$group = bhg_medalboard::getGroup($id);

		$this->setTitle($group->getName());

		$this->addBodyContent($group->getDescription());

		$this->addSideMenu($GLOBALS['holonet']->medalboard->getSideMenu());

	}

}

?>
