<?php

class page_roster_administration_system_position extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Edit Position');

		$form = new holonet_form('edit_members', 'post', '/roster/administration/system/edit/position');
	
		$options = array(0 => '-- Create New --');

		foreach ($GLOBALS['bhg']->roster->getPositions() as $item) {

			$options[$item->getID()] = $item->getName();

		}
		
		$form->addElement('select',
				'target',
				'Position:',
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
