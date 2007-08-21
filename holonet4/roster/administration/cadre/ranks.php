<?php

function cadre(&$form){
	$form->addElement('header', null, 'Cadre');
	$form->addElement('text', 'name', 'Name', array('size'=>15));
	$form->addElement('text', 'slogan', 'Slogan', array('size'=>25));
	$form->addElement('text', 'logo', 'URL of Logo', array('size'=>25));
	$form->addElement('textarea', 'welcome', 'Welcome Text for New Members<br /><br /><small>Text Replacements:<br />
		%N - Hunter\'s Name<br />
		%R - Hunter\'s Rank<br />
		%C - Cadre Name<br />
		%CR - Cadre Rank of User</small>', array('cols'=>45, 'rows'=>20));
}

class page_roster_administration_cadre_ranks extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;
		
		$this->setTitle('Cadre Management :: Ranks');

		$user = $GLOBALS['bhg']->user;
		
		if (!$user->isCadreLeader()){ $this->addBodyContent('You do not have authority to access this module.'); return; }
		
		$form = new holonet_form('cadre_ranks');
		$renderer =& $form->defaultRenderer();

		if (isset($_REQUEST['rank'])){
			$form->addElement('header', null, 'Rank Details');
			$form->addElement('hidden', 'rank', $values['rank']);
			$form->addElement('text', 'name', 'Name', array('size'=>25));
			$form->addElement('text', 'abbrev', 'Abbreviation', array('size'=>5, 'maxlength' => 5));
			$form->addElement('select', 'type', 'Type', array('core'=>'Core Member','standard'=>'Standard Member','initiate'=>'Initiate Member','inactive'=>'Inactive Member'));
			$form->addElement('header', null, 'Auto-Award Details');
			$form->addElement('checkbox', 'manuallyset', 'Set Manually?');
			$form->addElement('static', null, 'Set Manually', 'Check this box if this rank must be awarded by you manually. If checked, all options below will be ignored.');
			$form->addElement('text', 'requiredcredits', 'Credit Threshold', array('size'=>10,'maxlength'=>11));
			$form->addElement('checkbox', 'deposit', 'As Bank Deposit?');
			$form->addElement('static', null, 'Bank Despoit', 'If checked, when a hunter has donated to the Cadre Bank an amount of credits greater than or equal to the Credit Threshold, they will be auto-awarded this rank.');
			$form->addElement('checkbox', 'rankcredits', 'As Rank Credits?');
			$form->addElement('static', null, 'Rank Credits', 'If checked, when a hunter has earned an amount of Rank Credits greater than or equal to the Credit Threshold, they will be auto-awarded this rank.');
			
			if ($_REQUEST['rank'] != -1){
				$rank = $GLOBALS['bhg']->roster->getRank($_REQUEST['rank']);
				if (!$user->getCadre()->isEqualTo($rank->getDivision())){ $this->addBodyContent('You do not have authority to edit this rank.'); return; } 

				$form->setDefaults(
					array(
						'name'				=> $rank->getName(),
						'abbrev'			=> $rank->getAbbrev(),
						'type'				=> ($rank->isCore() ? 'core' : ($rank->isStandard() ? 'standard' : ($rank->isInitiate() ? 'initiate' : 'inactive'))),
						'manuallyset'		=> ($rank->isManuallySet() ? true : false),
						'requiredcredits'	=> ($rank->getRequiredCredits()),
						'despoit'			=> ($rank->isDeposit() ? true : false),
						'rankcredits'		=> ($rank->isRank() ? true : false),
						)
				);
				
			} 

			$form->addButtons('Commit');
		} else {
			$values = array('-1' => '-- Create New Rank --');
	
			$filter['division'] = $user->getCadre();
			
			$elements = $GLOBALS['bhg']->roster->getRanks($filter);
			foreach ($elements as $element)
				$values[$element->getID()] = $element->getName() . ' ('.$element->getAbbrev().')';
			
			$form->addElement('select', 'rank', 'Edit Rank', $values);
			
			$form->addButtons('Edit');
		}
		
		$this->addBodyContent($form);

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
