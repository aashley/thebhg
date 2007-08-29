<?php

class page_roster_administration_my_invites extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Accept Invites');

		$user = $GLOBALS['bhg']->user;
		
		$pending = $GLOBALS['bhg']->roster->getPendingTransfers(array('person' => $user, 'invite' => 1));
		
		if (!$pending->count())
			$this->addBodyContent('<p>No pending invites.</p>');
		else {
			$options = array(-1 => '-- Deny All --');
			
			foreach ($pending as $invite){
				$options[$invite->getID()] = $invite->getTarget()->getName();
 			}
			
			$form = new holonet_form('my_tranfer');
	
			$form->addElement('select',
					'target',
					'Accept Invite:',
					$options);
	
			$form->addButtons('Accept Invite');
			
			if ($form->validate()) {

				$values = $form->exportValues();
	
				$this->addBodyContent('<p>');
	
				foreach ($pending as $invite){
					$this->addBodyContent('Invitation to join ' . $invite->getTarget()->getName() . '...');
					if ($invite->getID() != $values['target']){ $invite->deny(); $this->addBodyContent('Denied.<br />'); }
					else { $invite->approve(); $this->addBodyContent('Accepted.<br />'); }
					
				}
				
				$this->addBodyContent('</p>');
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
