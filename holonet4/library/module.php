<?php

include_once 'HTML/Table.php';
include_once 'objects/holonet/form.php';

class holonet_module_library extends holonet_module {

	public function __construct() {

		parent::__construct('library', 'Library');

		$this->setMenu(new holonet_menu('roster/menu.xml'));

	}

	public function getDefaultPage($trail) {

		include_once 'library/default.php';
		return new page_library_default($trail);

	}

	public function getBookMenu() {

		$menus = array();

		foreach ($GLOBALS['bhg']->library->getShelves() as $shelf) {
			
			$menu = new holonet_menu;
			$menu->title = $shelf->getName();
			
			foreach ($shelf->getBooks() as $book)
				$menu->addItem(new holonet_menu_item($book->getName(), '/library/book/'.$book->getID()));

			$menus[] = $menu;

		}

		return $menus;

	}

	public function buildShelfTab(bhg_library_shelf $shelf) {

		$tab = new holonet_tab('shelf_'.$shelf->getID(), $shelf->getName());

		$tab->addContent('<p>'.$shelf->getDescription().'</p>');

		$books = $shelf->getBooks();

		if ($books->count() > 0) {
			
			$tab->addContent('<ul>');

			foreach ($books as $book) {

				$tab->addContent('<li>'.holonet::output($book).'</li>');

			}

			$tab->addContent('</ul>');

		}

		return $tab;

	}

}

?>
