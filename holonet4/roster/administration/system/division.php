<?php

class page_roster_administration_system_division extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Edit Divisions');
		
		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildDivision());
		$bar->addTab($this->buildCadre());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}
	
	private function buildDivision() {
		
		$tab = new holonet_tab('division_tab', 'Manage Divisions');
		
		$form = new holonet_form('edit_members', 'post', '/roster/administration/system/edit/division');
	
		$options = array(0 => '-- Create New --');

		foreach ($GLOBALS['bhg']->roster->getDivisions(array('cadre' => false)) as $item) {

			$options[$item->getID()] = $item->getName();

		}
		
		$form->addElement('select',
				'target',
				'Division:',
				$options);

		$form->addButtons('Process');

		$tab->addContent($form);

		return $tab;

	}
	
	private function buildCadre() {
		
		$tab = new holonet_tab('cadre_tab', 'Manage Cadres');
		
		$form = new holonet_form('edit_members', 'post', '/roster/administration/system/edit/cadre');
	
		$options = array(0 => '-- Create New --');

		foreach ($GLOBALS['bhg']->roster->getCadres() as $item) {

			$options[$item->getID()] = $item->getName();

		}
		
		$form->addElement('select',
				'target',
				'Cadre:',
				$options);

		$form->addButtons('Process');

		$tab->addContent($form);

		return $tab;

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
