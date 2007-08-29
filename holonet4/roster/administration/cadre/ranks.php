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

		if (isset($_REQUEST['name'])){
			if ($_REQUEST['rank'] != -1){
				$rank = $GLOBALS['bhg']->roster->getRank($_REQUEST['rank']);
				if (!$user->getCadre()->isEqualTo($rank->getDivision())){ $this->addBodyContent('You do not have authority to edit this rank.'); return; } 

				try {
					if (isset($_REQUEST['weight'])){
						$switch = $GLOBALS['bhg']->roster->getRank($_REQUEST['weight']);
						$from 	= $switch->getSortOrder();
						$to		= $rank->getSortOrder();
						
						$switch->setSortOrder($to);
						$rank->setSortOrder($from);
					}
					
					$this->addBodyContent('Attempting to update ' . $rank->getName() . '...');
					
					$rank->setName($_REQUEST['name']);
					$rank->setAbbrev($_REQUEST['abbrev']);
					
					foreach (array('core','initiate','standard','inactive') as $bit){
						$update = 'set' . ucfirst($bit);
						$rank->$update(($_REQUEST['type'] == $bit ? 1 : 0));
					}

					if (isset($_REQUEST['manuallyset'])){
						$rank->setManuallySet(true);
						$rank->setRequiredCredits(0);
						$rank->setDeposit(false);
						$rank->setRank(false);
					} else {
						$rank->setManuallySet(false);
						$rank->setRequiredCredits(str_replace(',', '', $_REQUEST['requiredcredits']));
						$rank->setDeposit((isset($_REQUEST['deposit']) ? true : false));
						$rank->setRank((isset($_REQUEST['rankcredits']) ? true : false));
					}
					
					$this->addBodyContent('Success');
							
				} catch (Exception $e) {
					$this->addBodyContent('Failed.');	
				}
				
			} else {
				$after = $GLOBALS['bhg']->roster->getRank($_REQUEST['weight']);
				
				$sort = $after->getSortOrder() + 1;
				
				$filter['division'] = $user->getCadre();
				$filter['threshold'] = $after->getSortOrder();
				
				foreach ($GLOBALS['bhg']->roster->getRanks($filter) as $elem)
					$elem->setSortOrder(($elem->getSortOrder() + 1));
				
				if (isset($_REQUEST['manuallyset'])){
						$manuallyset = 1;
						$requiredcreds = 0;
						$deposit = 0;
						$rankbit = 0; 
					} else {
						$manuallyset = 0;
						$requiredcreds = str_replace(',', '', $_REQUEST['requiredcredits']);
						$deposit = (isset($_REQUEST['deposit']) ? 1 : 0);
						$rankbit = (isset($_REQUEST['rankcredits']) ? 1 : 0); 
					}
				
				$array = array(
						'name' => $_REQUEST['name'],
						'abbrev' => $_REQUEST['abbrev'],
						'division' => $user->getCadre()->getID(),
						'manuallyset' => $manuallyset,
						'requiredcredits' => $requiredcreds,
						'deposit'	=> $deposit,
						'rank'	=> $rankbit,
						'cadre'	=> 1,
						'sortorder' => $sort,
						$_REQUEST['type'] => 1,
					);
					
				try {
					$this->addBodyContent('Attempting to add Rank ' . $_REQUEST['name'] . '...');
					$rank = $GLOBALS['bhg']->roster->createRank($array);
					$this->addBodyContent('Success.');
				} catch (Exception $e){
					$this->addBodyContent('Failed.');
				}
					
			}
		} elseif (isset($_REQUEST['rank'])){
			$form->addElement('header', null, 'Rank Details');
			$form->addElement('hidden', 'rank', $values['rank']);
			$form->addElement('text', 'name', 'Name', array('size'=>25));
			$form->addElement('text', 'abbrev', 'Abbreviation', array('size'=>5, 'maxlength' => 5));
			$form->addElement('select', 'type', 'Type', array('core'=>'Core Member','standard'=>'Standard Member','initiate'=>'Initiate Member','inactive'=>'Inactive Member'));
			if ($_REQUEST['rank'] != -1){
				$rank = $GLOBALS['bhg']->roster->getRank($_REQUEST['rank']);
				if (!$user->getCadre()->isEqualTo($rank->getDivision())){ $this->addBodyContent('You do not have authority to edit this rank.'); return; } 
			
				if (!$rank->isLocked()){
					$filter['division'] = $user->getCadre();
					
					$elements = $GLOBALS['bhg']->roster->getRanks($filter);
					foreach ($elements as $element)
						if(!$element->isLocked()) $values[$element->getID()] = $element->getName() . ' ('.$element->getAbbrev().')';
					
					$wei =& $form->addElement('select', 'weight', ($_REQUEST['rank'] != -1 ? 'Change With' : 'Insert After'), $values);
				}
			}
			$form->addElement('header', null, 'Auto-Award Details');
			$man =& $form->addElement('checkbox', 'manuallyset', 'Set Manually?');
			$form->addElement('static', null, 'Set Manually', 'Check this box if this rank must be awarded by you manually. If checked, all options below will be ignored.');
			$form->addElement('text', 'requiredcredits', 'Credit Threshold', array('size'=>10,'maxlength'=>11));
			$dep =& $form->addElement('checkbox', 'deposit', 'As Bank Deposit?');
			$form->addElement('static', null, 'Bank Despoit', 'If checked, when a hunter has donated to the Cadre Bank an amount of credits greater than or equal to the Credit Threshold, they will be auto-awarded this rank.');
			$ran =& $form->addElement('checkbox', 'rankcredits', 'As Rank Credits?');
			$form->addElement('static', null, 'Rank Credits', 'If checked, when a hunter has earned an amount of Rank Credits greater than or equal to the Credit Threshold, they will be auto-awarded this rank.');
			
			if (is_object($rank)){
				$man->setChecked(true);
				
				$form->setDefaults(
					array(
						'name'				=> $rank->getName(),
						'abbrev'			=> $rank->getAbbrev(),
						'type'				=> ($rank->isCore() ? 'core' : ($rank->isStandard() ? 'standard' : ($rank->isInitiate() ? 'initiate' : 'inactive'))),
						'requiredcredits'	=> ($rank->getRequiredCredits()),
						'weight'			=> $rank->getID(),
						)
				);

				$man->setChecked($rank->isManuallySet());
				$dep->setChecked($rank->isDeposit());
				$ran->setChecked($rank->isRank());
				
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

		return $user->isCadreLeader();

	}

}

?>
