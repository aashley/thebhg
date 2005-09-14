<?php

class page_holonet_default extends holonet_page {

	public function buildPage() {

		$this->setTitle('Holonet News');

		$this->addBodyContent('<p>Hello World</p>');

		$person = bhg_roster::getPerson(94);

		$this->addBodyContent('<p>'.$person->getIDLine().'</p>');

		$menu = new holonet_menu();
		$menu->title = 'News';
		$menu->addItem(new holonet_menu_item('News', '/holonet/'));
		$menu->addItem(new holonet_menu_item('Adminstration', '/holonet/manage'));

		$this->addSideMenu($menu);

	}

}

?>
