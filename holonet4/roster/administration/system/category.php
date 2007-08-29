<?php

class page_roster_administration_system_category extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Edit Division Categories');

		$form = new holonet_form('edit_members', 'post', '/roster/administration/system/edit/category');
	
		$options = array(0 => '-- Create New --');

		foreach ($GLOBALS['bhg']->roster->getDivisionCategories() as $item) {

			$options[$item->getID()] = $item->getName();

		}
		
		$form->addElement('select',
				'target',
				'Division Category:',
				$options);

		$form->addButtons('Process');

		$this->addBodyContent($form);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		if (	 $user->getID() == 2650
				|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))) {

			return true;

		} else {

			return false;

		}

	}

}

?>
