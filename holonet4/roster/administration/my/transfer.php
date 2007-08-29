<?php

class page_roster_administration_my_transfer extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('My Transfers');

		$user = $GLOBALS['bhg']->user;

		$retirees = bhg_roster::getDivision(12);
		$kabal = bhg_roster::getDivision(25);
		
		$options = array();

		$pending = $GLOBALS['bhg']->roster->getPendingTransfers(array('person' => $user));
		
		if ($pending->count()){
			
			$form = new holonet_form('my_tranfer');
			
			$form->addElement('static',
					null,
					'Current Pending Transfer',
					$pending->getItem()->getTarget()->getName());
	
			$form->addButtons('Cancel Transfer');
	
			$form->setDefaults(
					array(
						'target'	=> $user->getDivision()->getID(),
						)
					);
	
			if ($form->validate()) {
	
				$values = $form->exportValues();
	
				try {
	
					$this->addBodyContent('<p>Canceling transfer request to '.$pending->getItem()->getTarget()->getName().'... ');
	
					$pending->getItem()->deny();
	
					$this->addBodyContent('Success.</p>');
					
				} catch (bhg_fatal_exception $e) {
	
					$this->addBodyContent('Failure.</p>');
					$this->addBodyContent($e->__toString());
	
				}
	
			} else {
	
				$this->addBodyContent($form);
	
			}
			
		} else {
		
			if (	 $user->getPosition()->isEqualTo(bhg_roster::getPosition(11))
					|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(12))) {
	
				$options[$user->getDivision()->getID()] = $user->getDivision()->getName().' (Retire as Chief)';
				$options[$user->getPreviousDivision()->getID()] = $user->getPreviousDivision()->getName();
				$options[$retirees->getID()] = $retirees->getName();
	
			}
	
			$canTransfer = false;
			
			try {
				$lastTransferDate = $user->getDateLastTransfer();
				
				$lastTransferDate->addSeconds(86400 * 30);
		
				if (	 $lastTransferDate->isPast() 
						|| $user->getDivision()->isEqualTo(bhg_roster::getDivision(10))
						|| $user->getDivision()->isEqualTo(bhg_roster::getDivision(18))
						|| $user->getDivision()->isEqualTo(bhg_roster::getDivision(12))) {
					$canTransfer = true;
				}
			} catch (Exception $e) {
				$canTransfer = true;
			}
			
			if ($canTransfer = true){
				$targets = $GLOBALS['bhg']->roster->getDivisions(array('category' => bhg_roster::getDivisionCategory(5)));
				$targets->append($retirees); $targets->append($kabal);
				$options = array();
		
				foreach ($targets as $target) {
					if ($target->isEqualTo($user->getDivision())) continue;
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
			
		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

}

?>
