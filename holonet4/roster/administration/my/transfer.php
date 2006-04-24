<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_administration_my_transfer extends holonet_page {

	public function __contruct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Request Transfer');

		$user = $GLOBALS['bhg']->user;

		$targets = $GLOBALS['bhg']->roster->getDivisions(array('category' => bhg_roster::getDivisionCategory(2)));

		// Add Retirees
		$targets->items[] = 2;

		$options = array();

		foreach ($targets as $target) {

			$options[$target->getID()] = $target->getName();

		}

		$form = new holonet_form('my_tranfer');

		$form->addElement('select',
				'target',
				'Transfer To:',
				$options);

		$form->addButtons('Request Transfer');

		$form->setDefaults(
				array(
					'target'	=> $user->getDivision()->getID(),
					)
				);

		if ($form->validate()) {

			$values = $form->exportValues();

			try {

				$target = bhg_roster::getDivision($values['target']);

				$this->addBodyContent('<p>Requesting transfer to '.$target->getName().'... ');

				$user->requestTransfer($target);

				$this->addBodyContent('Success.</p>');

			} catch (bhg_fatal_exception $e) {

				$this->addBodyContent('Failure.</p>');
				$this->addBodyContent($e->__toString());

			}

		} else {

			$this->addBodyContent($form);

		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

}

?>
