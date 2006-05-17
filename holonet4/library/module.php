<?php

include_once 'HTML/Table.php';
include_once 'objects/holonet/form.php';

class holonet_module_library extends holonet_module {

	public function __construct() {

		parent::__construct('library', 'Library');

		$this->setMenu(new holonet_menu('roster/menu.xml'));

	}

	public function getDefaultPage($trail) {

		if (	 count($trail) == 0
				|| $trail[0] == 'library') {
			
			include_once 'library/default.php';
			return new page_library_default($trail);

		}

		if (	 isset($trail[1])
				&& is_numeric($trail[1])) {

			include_once 'library/read.php';
			return new page_library_read(array(bhg_library::getChapter($trail[1])));

		} elseif (	 isset($trail[0])
							&& is_numeric($trail[1])) {

			include_once 'library/read.php';
			return new page_library_read(array(bhg_library::getBook($trail[0])));

		}

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
