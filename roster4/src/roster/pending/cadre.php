<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev: 5524 $ $Date: 2007-08-20 08:49:27 -0400 (Mon, 20 Aug 2007) $
 */

/**
 * Roster Pending Credit Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev: 5524 $ $Date: 2007-08-20 08:49:27 -0400 (Mon, 20 Aug 2007) $
 */
class bhg_roster_pending_cadre extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_pending_cadre', $id);
		$this->__addFieldMap(array(
					'leader'	=> 'bhg_roster_person',
					'member1'	=> 'bhg_roster_person',
					'member2'	=> 'bhg_roster_person',
					'member3'	=> 'bhg_roster_person',
					'member4'	=> 'bhg_roster_person',
					'member5'	=> 'bhg_roster_person',
					'member6'	=> 'bhg_roster_person',
					));
		$this->__addBooleanFields(array('confederation'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	
	// {{{ approve()
	
	/**
	 * Approve this credit request
	 *
	 * return boolean
	 */
	public function approve() {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			$cadre = $this->__createRecord('roster_division',
					array(
						'name' => $this->getName(),
						'category' => 5,	
						'cadre'	=> 1,
						'leader' => $this->getLeader()->getID(),
						'slogan' => $this->getSlogan(),
						'logo' => $this->getLogo(),
						'welcomemessage' => $this->getWelcome(),
					));
		
			$rank = $this->__createRecord('roster_rank',
					array(
						'name' => 'Cadre Leader',
						'abbrev' => 'LEADER',
						'division' => $cadre->getID(),
						'manuallyset' => 1,
						'locked' => 1,
						'cadre'	=> 1,
						'core' => 1,
						'sortorder' => -1,
					));
					
			$default = $this->__createRecord('roster_rank',
					array(
						'name' => 'Cadre Initiate',
						'abbrev' => 'INITIATE',
						'division' => $cadre->getID(),
						'manuallyset' => 1,
						'locked' => 1,
						'cadre'	=> 1,
						'initiate' => 1,
						'sortorder' => -1,
					));
						
			$cadre->setDefaultRank($default->getID());
					
			$leader = $this->getLeader();
			$leader->setDivision($cadre);
			$leader->setCadreRank($rank);
			$leader->setLocked(1);
			
			if ($this->isConfederation()){
				$leader->cadreDeposit(2000000, 'Confederate Opening Deposit');
				
				$rank = $this->__createRecord('roster_rank',
					array(
						'name' => 'Confederate Founder',
						'abbrev' => 'FOUNDER',
						'division' => $cadre->getID(),
						'manuallyset' => 1,
						'locked' => 1,
						'cadre'	=> 1,
						'core' => 1,
						'sortorder' => 0,
					));
					
				for ($i = 1; $i <= 6; ++$i){
					$frmt = 'getMember' . $i . '()';
					$usr = $this->$frmt;
					$usr->setDivision($cadre);
					$usr->setCadreRank($rank);
					$usr->setLocked(1);
					$usr->cadreDeposit(2000000, 'Confederate Opening Deposit');		
				}
				
			}
					
			if ($cadre)
				$this->delete();

			return $return;

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ deny()

	/**
	 * Deny this credit request
	 *
	 * return boolean
	 */
	public function deny() {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			return $this->__purgeRecord();

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}

}

?>
