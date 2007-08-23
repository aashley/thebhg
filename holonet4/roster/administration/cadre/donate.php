<?php

class page_roster_administration_cadre_donate extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Cadre :: Donate');

		$user = $GLOBALS['bhg']->user;
		
		if (!$user->inCadre()){ $this->addBodyContent('You are not in a cadre.'); return; }
		
		$cadre = $user->getCadre();
		
		$form = new holonet_form('donate_cadre');
		$renderer =& $form->defaultRenderer();
		
		$form->addElement('header', null, 'Donate Credits');
		$form->addElement('static', null, 'My Account Balance', holonet::formatCredits($user->getAccountBalance()));
		$form->addElement('static', null, 'Cadre Account Balance', holonet::formatCredits($cadre->getAccountBalance()));
		$form->addElement('text', 'creds', 'Donation Amount:', array('size'=>10));
		
		$form->addButtons('Donate Credits');
		
		if ($form->validate()) {

			$values = $form->exportValues();

			try {
				$values['creds'] = str_replace(',', '', $values['creds']);
				$this->addBodyContent('<p>Attempting to donate '. holonet::formatCredits($values['creds']) . ' to ' . $cadre->getName() . '...');
				
				if ($values['creds'] <= 0){
					$this->addBodyContent('Failed. You cannot donate 0 or negative credits.');
					$this->addBodyContent($form);
				} else if ($user->getAccountBalance() >= $values['creds']){
					$user->cadreDeposit($values['creds']);
					$this->addBodyContent('Success.</p>');
				} else { 
					$this->addBodyContent('Failed. You do not have enough credits.');
					$this->addBodyContent($form);
				}
					
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

function _checkOldPassword($value, $limit = null) {

	return $GLOBALS['bhg']->user->checkPassword($value);

}

?>
