<?php

include_once 'HTML/Table.php';
include_once 'objects/holonet/form.php';

class holonet_module_medalboard extends holonet_module {

	public function __construct() {

		parent::__construct('medalboard', 'Medal Board');

		$this->setMenu(new holonet_menu('medalboard/menu.xml'));

	}

	public function getDefaultPage($trail) {

		include_once 'medalboard/default.php';
		return new page_medalboard_default($trail);

	}

	public function getSideMenu() {

		$menus = array();

		foreach ($GLOBALS['bhg']->medalboard->getCategories() as $category) {
			
			$menu = new holonet_menu;
			$menu->title = $category->getName();
			
			foreach ($category->getGroups() as $group)
				$menu->addItem(new holonet_menu_item($group->getName(), '/medalboard/group/'.$group->getID()));

			$menus[] = $menu;

		}

		return $menus;

	}

}

?>
