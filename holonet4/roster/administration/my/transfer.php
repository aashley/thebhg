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

		$retirees = bhg_roster::getDivision(12);

		$options = array();

		if ($user->getPosition()->isEqualTo(bhg_roster::getPosition(11))) {

			$options[$user->getDivision()->getID()] = $user->getDivision()->getName().' (Retire as Chief)';
			$options[$user->getPreviousDivision()->getID()] = $user->getPreviousDivision()->getName();
			$options[$retirees->getID()] = $retirees->getName();

		}

		$lastTransferDate = $user->getDateLastTransfer();
			
		$lastTransferDate->addSeconds(86400 * 30);

		if (	 $lastTransferDate->isPast() 
				|| $user->getDivision()->isEqualTo(bhg_roster::getDivision(10))
				|| $user->getDivision()->isEqualTo(bhg_roster::getDivision(18))
				|| $user->getDivision()->isEqualTo(bhg_roster::getDivision(12))) {
			
			$targets = $GLOBALS['bhg']->roster->getDivisions(array('category' => bhg_roster::getDivisionCategory(2)));
			$targets->append($retirees);
			$options = array();

			foreach ($targets as $target) {

				$options[$target->getID()] = $target->getName();

			}

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
