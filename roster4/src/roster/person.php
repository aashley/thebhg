<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */

/**
 * Roster Person Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_person extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_person', $id);
		$this->__blackListVar('get', array('md5password', 'passwd', 'redoranks'));
		$this->__blackListVar('set', array('md5password', 'passwd', 'redoranks', 'rankcredits'));
		$this->__addBooleanFields(array('ship', 'completedcoreexam', 'lha', 'inactive'));
		$this->__addFieldMap(array(
					'rank' => 'bhg_roster_rank',
					'cadrerank' => 'bhg_roster_rank',
					'division' => 'bhg_roster_division',
					'position' => 'bhg_roster_position',
					'previousdivision' => 'bhg_roster_division',
					));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addHistoryMap(array(
					'rank' => BHG_HISTORY_RANK,
					'cadrerank' => BHG_HISTORY_CADRE_RANK,
					'position' => BHG_HISTORY_POSITION,
					'division' => BHG_HISTORY_DIVISION,
					'name' => BHG_HISTORY_NAME,
					'email' => BHG_HISTORY_EMAIL,
					));
	}

	// }}}

	// {{{ checkPassword()

	/**
	 * Does the supplied password match this user
	 *
	 * @param string Password to check
	 * @return boolean
	 */
	public function checkPassword($password) {

		if (is_null($this->data['md5Password'])) {

			$hash = $this->db->getOne('SELECT OLD_PASSWORD(?)', array($password));

			return (strtolower($hash) == strtolower($this->data['passwd']));

		} else {

			return (strtolower(md5($password)) == strtolower($this->data['md5Password']));

		}

	}

	// }}}
	// {{{ getPeople()

	/**
	 * Get all people in this cadre
	 *
	 * @param array Filters to select which people to load
	 * @return bhg_core_list
	 */
	public function getCommittees($filter = array()) {

		$filter['person'] = $this;

		return $GLOBALS['bhg']->roster->getCommitteeMembers($filter);

	}

	// }}}
	// {{{ getCadre()
	
	/**
	 * Alias of getDivision
	 *
	 * @return object Date
	 */
	public function getCadre() {

		return $this->getDivision();

	}

	// }}}
	// {{{ getDateLastTransfer()
	
	/**
	 * Retrieve the Date of this person's last division transfer
	 *
	 * @return object Date
	 */
	public function getDateLastTransfer() {

		$events = $GLOBALS['bhg']->history->getEvents(array(
					'person'	=> $this,
					'type'		=> BHG_HISTORY_DIVISION,
					'limit'		=> 1,
					)
				);

		if ($events->count() > 0) {

			return $events->getItem()->getDateCreated();

		} else {

			throw new bhg_not_found('This person has not yet been transfered.');

		}

	}

	// }}}
	// {{{ pendingCadreRequest()
	
	/**
	 * Retrieve the Date of this person's last division transfer
	 *
	 * @return object Date
	 */
	public function hasPendingCadreRequest() {

		$filter['member'] = $this;

		$cadres = $GLOBALS['bhg']->roster->getPendingCadres($filter);

		return ($cadres->count() > 0);

	}

	// }}}	
	// {{{ getDateLastPromotion()
	
	/**
	 * Retrieve the Date of this person's last rank change
	 *
	 * @return object Date
	 */
	public function getDateLastPromotion() {

		$events = $GLOBALS['bhg']->history->getEvents(array(
					'person'	=> $this,
					'type'		=> BHG_HISTORY_RANK,
					'limit'		=> 1,
					)
				);

		if ($events->count() > 0) {

			return $events->getItem()->getDateCreated();

		} else {

			throw new bhg_not_found('This person has not yet received a transfer.');

		}

	}

	// }}}
	// {{{ getDisplayName()
	
	/**
	 * Get the regular display name for a person
	 *
	 * @return string
	 */
	public function getDisplayName() {

		return $this->getRank()->getName().' '.$this->getName();

	}

	// }}}
	// {{{ getExamSubmissions()

	/**
	 * Get the submissions this person has made to the college
	 *
	 * @param array Filters on which submissions to return
	 * @return bhg_core_list
	 */
	public function getExamSubmissions($filter = array()) {

		$filter['submitter'] = $this;

		return $GLOBALS['bhg']->college->getSubmissions($filter);

	}

	// }}}
	// {{{ getCollegeIDLine()

	/**
	 * Generates the College part of the ID line.
	 *
	 * @return string
	 */
	public function getCollegeIDLine() {

		$submissions = $GLOBALS['bhg']->college->getSubmissions(array('passed'    => true,
			'submitter' => $this));

		if ($submissions->count() > 0) {
			
			$submissions->sort(array('getExam', 'getAbbr'));
			$abbrs = array();
			
			foreach ($submissions as $sub)
				$abbrs[] = $sub->getExam()->getAbbr();

			return '{'.implode('-', $abbrs).'}';

		}

		return '';

	}
	
	// }}}
	// {{{ getHistory()

	/**
	 * Retrieves all history events related to this person.
	 *
	 * @return bhg_core_list A list of bhg_history_event objects.
	 */
	public function getHistory($filter = array()) {

		$filter['person'] = $this;

		return $GLOBALS['bhg']->history->getEvents($filter);

	}

	// }}}
	// {{{ getBiographicalData()

	/**
	 * Retrieves all history events related to this person.
	 *
	 * @return bhg_core_list A list of bhg_history_event objects.
	 */
	public function getBiographicalData($filter = array()) {

		$filter['person'] = $this;

		try {
			$elem = $GLOBALS['bhg']->roster->getBiographicalData($filter)->getItem();
		} catch (Exception $e){
			$u = 'Unknown';
			$elem = $this->__createRecord('roster_biographical_data', array(
						'person' 	=> $this->data['id'],
						'homeworld' => $u,
						'species' 	=> $u,
						'height' 	=> $u,
						'sex' 		=> $u,
						'age' 		=> -1,
						));
		}

		return $elem;
	}

	// }}}
	// {{{ getHistory()

	/**
	 * Retrieves all history events related to this person.
	 *
	 * @return bhg_core_list A list of bhg_history_event objects.
	 */
	public function getBankHistory($filter = array()) {

		$filter['person'] = $this;

		return $GLOBALS['bhg']->bank->getEvents($filter);

	}

	// }}}
	// {{{ getIDLine()

	/**
	 * Get the ID Line of this person
	 *
	 * @param boolean True for the full ID line, false for the short version.
	 * @return string
	 */
	public function getIDLine($showFull = false) {

		$div = $this->getDivision()->getName();

		$gmt = 'BHG';
		
		if ($this->isLHA() && $this->isActive()) $gmt = 'LHA';
		
		if (strlen(($special = $this->getPosition()->getSpecialDivision()))) $gmt = $special;

		$idline = $this->getDisplayName() .
			($this->inCadre() ? ', '.$this->getCadreRank()->getAbbrev() : '')
			.'/'
			.$div
			.'/'
			.$gmt
			.' -'.$this->getPosition()->getAbbrev();

		if ($showFull) {
			$medal = $this->getMedalIDLine();
			$citadel = $this->getCollegeIDLine();

			if (strlen($medal) > 0)
				$idline .= " $medal";

			if (strlen($citadel) > 0)
				$idline .= " $citadel";
		}

		return $idline;

	}

	// }}}
	// {{{ getMedalIDLine()

	/**
	 * Returns the medal portion of the person's ID line.
	 *
	 * @return string
	 */

	public function getMedalIDLine() {

		$out = array();

		foreach ($GLOBALS['bhg']->medalboard->getCategories() as $category)
			foreach ($category->getGroups() as $group) {
				if ($group->getDisplayType() == 0) {

					// Traditional BHG medals.

					$last = 0;
					$groupout = array();
					foreach ($group->getMedals() as $medal) {
						
						$awards = $GLOBALS['bhg']->medalboard->getAwards(array('medal' => $medal, 'recipient' => $this));

						$pos = 0;
						foreach ($awards as $award) {

							$groupout[$pos++] = $group->getStartBracket()
								.$medal->getAbbrev()
								.$group->getEndBracket();

						}

						/* Trying new code
						if ($awards->count() < $last) {
							$last = $awards->count();
							$out[] = $group->getStartBracket()
											.$medal->getAbbrev()
											.$group->getEndBracket();
						}
						elseif ($awards->count() > $last) {
							$diff = $awards->count() - $last;
							$last = $awards->count();
							for ($i = 0; $i < $diff; $i++)
								$out[] = $group->getStartBracket()
												.$medal->getAbbrev()
												.$group->getEndBracket();

						}
						*/

					}

					$out = array_merge($out, $groupout);

				} elseif ($group->getDisplayType() == 1) {

					// Medals of the form ABBRxN.
					
					$awards = $GLOBALS['bhg']->medalboard->getAwards(array('group'     => $group,
																																 'recipient' => $this));

					if ($awards->count() > 0) {
						$medalOut = $group->getAbbrev();
						if ($awards->count() != 1)
							$medalOut .= 'x'.$awards->count();
						$out[] = $group->getStartBracket()
										.$medalOut
										.$group->getEndBracket();

					}
					
				} elseif ($group->getDisplayType() == 2) {

					// Medals of the form CoXxN.
					
					foreach ($group->getMedals() as $medal) {
						$medalAwards = $GLOBALS['bhg']->medalboard->getAwards(array('medal'     => $medal,
																																				'recipient' => $this));

						if ($medalAwards->count() > 0) {
							$medalOut = $medal->getAbbrev();
							if ($medalAwards->count() != 1)
								$medalOut .= 'x'.$medalAwards->count();
							$out[] = $group->getStartBracket()
											.$medalOut
											.$group->getEndBracket();

						}

					}
					
				}

			}

		return implode(' ', $out);

	}
	
	// }}}
	// {{{ getMedals()

	/**
	 * Retrieves all medal awards made to this person.
	 *
	 * @return bhg_core_list A list of bhg_medalboard_award objects.
	 */
	public function getMedals() {

		return $GLOBALS['bhg']->medalboard->getAwards(
				array(
					'recipient' => $this,
					));

	}

	// }}}

	// {{{ isActive()

	/**
	 * Is this person considered active?
	 *
	 * @return boolean
	 */
	public function isActive() {

		if ($this->isDeleted())
			return false;

		return !($this->data['division'] == 11 || $this->data['division'] == 12 || $this->data['inactive'] == 1);

	}

	// }}}
	// {{{ inCadre()

	/**
	 * Is this person in a cadre?
	 *
	 * @param bhg_roster_division
	 * @return boolean
	 */
	public function inCadre($cadre = null) {

		if (is_null($cadre)) {

			return $this->getDivision()->isCadre();

		} else {

			if (!$this->getDivision()->isCadre())
				return false;

			return $cadre->isEqualTo($this->getDivision());

		}

	}

	// }}}
	// {{{ isCadreLeader()

	/**
	 * Is this person the Leader of the Cadre they are in?
	 *
	 * @return boolean
	 */
	public function isCadreLeader() {

		if ($this->inCadre())
			return $this->getCadre()->getLeader()->isEqualTo($this);
		
		return false;
	}

	// }}}
	// {{{ isDivision()

	/**
	 * Is this person in a specific division?
	 *
	 * @param bhg_roster_division
	 * @return boolean
	 */
	public function inDivision(bhg_roster_division $division) {

		$pure = $this->getDivision()->isEqualTo($division);
		if ($this->getPosition()->hasPosDiv())
			$pos = $this->getPosition()->getDivision()->isEqualTo($division);
			
		return ($pure || $pos);

	}

	// }}}
	// {{{ isHunter()

	/**
	 * Is this person a Hunter?
	 *
	 * @return boolean
	 */
	public function isHunter() {

		return !$this->getPosition()->IsTrainee();

	}

	// }}}

	// {{{ awardCredits()

	/**
	 * Add credits to this person's rank account
	 *
	 * @param integer Credits to award
	 * @param bhg_roster_person The person awarding the credits
	 * @param string The reason the credits are awarded
	 * @return boolean
	 */
	public function awardCredits($credits, bhg_roster_person $awarder, $reason = '') {

		if ($GLOBALS['bhg']->hasPerm('credits')) {
			
			$result = $this->__saveValue(array(
						'rankcredits' => array("(rankcredits + $credits)", true),
						));

			$this->__recordHistoryEvent(BHG_HISTORY_CREDIT, $this, $awarder->getID(), $credits, $this->getRankCredits(), $reason);

			$this->handleRank();

			return $result;

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ removeCredits()

	/**
	 * Remove credits from this person's rank account
	 *
	 * @param integer Credits to remove
	 * @param bhg_roster_person The person removing the credits
	 * @param string the reason the credits are being removed
	 * @return boolean
	 */
	public function removeCredits($credits, bhg_roster_person $awarder, $reason = '') {

		return $this->awardCredits(-$credits, $awarder, $reason);

	}

	// }}}
	// {{{ accountTransfer()

	/**
	 * Withdraw credits from account balance
	 *
	 * @param integer Cost of purchase
	 * @param string The reason for the withdrawl
	 * @param string The location that the withdrawl was done
	 * @return boolean
	 */
	public function accountTransfer($credits, $to, $for) {

		$this->withdrawAccount(-$credits, $to->getID(), $for);
		$to->depositAccount($credits, $this->getID(), $for);
		
	}

	// }}}
	// {{{ withdrawAccount()

	/**
	 * Withdraw credits from account balance
	 *
	 * @param integer Cost of purchase
	 * @param string The reason for the withdrawl
	 * @param string The location that the withdrawl was done
	 * @return boolean
	 */
	public function withdrawAccount($credits, $from, $for, $cadre = 0) {

		return $this->depositAccount(-$credits, $from, $for, $cadre);

	}

	// }}}
	// {{{ depositAccount()

	/**
	 * Make a deposit into the account
	 *
	 * @param integer amount of deposit
	 * @param string The reason for the deposit
	 * @param string The location that the deposit was done
	 * @return boolean
	 */
	public function depositAccount($credits, $from, $for, $cadre = 0) {

		if ($GLOBALS['bhg']->hasPerm('purchase')) {
			
			$result = $this->__createRecord('roster_person_bank', array(
						'person' => $this->data['id'],
						'amount' => $credits,
						'reason' => $for,
						'source' => $from,
						'cadre' => $cadre,
						),
						false);

			$this->handleRank();
						
			return $result;

		} else {

			throw new bhg_coder_exception();

		}
		
	}

	// }}}
	// {{{ cadreDeposit()

	/**
	 * Withdraw credits from account balance
	 *
	 * @param integer Cost of purchase
	 * @param string The reason for the withdrawl
	 * @param string The location that the withdrawl was done
	 * @return boolean
	 */
	public function cadreDeposit($credits, $for = 'Direct Deposit') {

		$this->withdrawAccount($credits, '', $for, $this->getDivision()->getID());
		$this->getDivision()->depositAccount($credits, $this->getID(), $for);
		
	}

	// }}}
	// {{{ awardMedal()
	/**
	 * Awards the appropriate medal
	 *
	 * @return mixed
	 */
	public function awardMedal($medal, $awarder, $reason){
		switch (get_class($medal)){
			case 'bhg_medalboard_group':
					$award = $medal->getMedals();
					if ($medal->getDisplayType() != 0){
						$medal = $award->getItem(); break;}
					
					$medals = $GLOBALS['bhg']->medalboard->getAwards(array('group' => $medal, 'recipient' => $this));
					
					try {
						$current = $award->gotoItemByValue($medals->getItem($medals->last())->getMedal());
						if (($current + 1) == $award->count())
							$current = 0;
						else ++$current;
					} catch (Exception $e){
						$current = 0;
					}
					
					$medal = $award->getItem($current);					
				break;
				
			case 'bhg_medalboard_medal':
				//Current medal is the medal to award.
				break;
		}
		
		$result = $this->__createRecord('medalboard_award', array(
						'recipient' => $this->data['id'],
						'medal' => $medal->getID(),
						'reason' => $reason,
						'awarder' => $awarder->getID(),
						));

		$this->handleRank();
					
		return $result;
	}
	
	// }}}
	// {{{ requestCreditAward()
	
	/**
	 * Request a credit award for this person
	 *
	 * @param object bhg_roster_division
	 * @param integer
	 * @param integer
	 * @param string
	 * @return boolean
	 */
	public function requestCreditAward(bhg_roster_person $awarder, $amount, $account, $reason) {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			return $this->__createRecord('roster_pending_credit',
					array(
						'recipient' => $this->getID(),
						'awarder' => $awarder->getID(),
						'amount' => $amount,
						'account' => $account,
						'reason' => $reason,
						));
						
		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ requestCreditAward()
	
	/**
	 * Request a credit award for this person
	 *
	 * @param object bhg_roster_division
	 * @param integer
	 * @param integer
	 * @param string
	 * @return boolean
	 */
	public function requestMedalAward(bhg_roster_person $awarder, $medal, $reason, $isMedal = false) {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			return $this->__createRecord('roster_pending_medal',
					array(
						'recipient' => $this->getID(),
						'awarder' => $awarder->getID(),
						'medal' => $medal,
						'medaltype' => ($isMedal ? 'medal' : 'group'),
						'reason' => $reason,
						));
						
		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ requestTransfer()
	
	/**
	 * Request a transfer to a new division for this person
	 *
	 * @param object bhg_roster_division
	 * @return boolean
	 */
	public function requestTransfer(bhg_roster_division $target, $invite = 0) {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			return $this->__createRecord('roster_pending_transfer',
					array(
						'person' => $this->getID(),
						'target' => $target->getID(),
						'invite' => $invite,
						));

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ requestCreateCadre()
	
	/**
	 * Request to create a new cadre
	 *
	 * @return boolean
	 */
	public function requestCreateCadre($name, $slogan, $logo, $welcome, $confederates = array()) {

		if ($GLOBALS['bhg']->hasPerm('god')) {
			if (!is_array($confederates)) $confederates = array();
			
			$submit = array(
				'leader' => $this->getID(),
				'name' => $name,
				'slogan' => $slogan,
				'logo' => $logo,
				'welcome' => $welcome,
			);
			
			if (count($confederates)){
				$confeds = array(
					'member1' => $confederates[0]->getID(),
					'member2' => $confederates[1]->getID(),
					'member3' => $confederates[2]->getID(),
					'member4' => $confederates[3]->getID(),
					'member5' => $confederates[4]->getID(),
					'member6' => $confederates[5]->getID(),
				);
				
				$submit = array_merge($submit, $confeds);
			}
			
			return $this->__createRecord('roster_pending_cadre', $submit);

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ setPassword()

	/**
	 * Set this users password
	 *
	 * @param string New Password
	 * @return boolean
	 * @throws bhg_validation_exception If the password does not meet BHG
	 * password requirements.
	 */
	public function setPassword($password) {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			if (strlen($password) < 4)
				throw new bhg_validation_exception('Password to short');

			return $this->__saveValue(array('md5Password' => strtolower(md5($password))));

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ transfer()
	
	/**
	 * Action a transfer
	 *
	 * @param object bhg_roster_division
	 * @return boolean
	 */
	public function transfer(bhg_roster_division $target) {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			if ($this->isCadreLeader()) return false;

			if ($target->isCadre()){
				if ($this->inCadre()){
					if (!$this->getCadreRank()->getDivision()->isEqualTo($target)){
						if (!$this->getCadre()->isEqualTo($target))
							$this->setCadreRank($target->getDefaultRank());
						}
				} else
					$this->setCadreRank($target->getDefaultRank());
			}		
			
			$division = $this->setDivision($target);

			$this->handleRank();
			
			return $division;

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}

	// {{{ delete()

	/**
	 * Delete this person
	 *
	 * @return boolean
	 */
	public function delete() {

		if ($GLOBALS['bhg']->hasPerm('bhg')) {

			parent::delete();

			$this->__recordHistoryEvent(BHG_HISTORY_DELETE, $this);

			return true;

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ delete()

	/**
	 * Returns the current credit amount in the person's bank
	 *
	 * @return boolean
	 */
	public function getAccountBalance(){
		$sql = 'SELECT SUM(`amount`) FROM `roster_person_bank` '
					.'WHERE person = "' . $this->data['id'] . '"';

		return $this->db->getOne($sql);
	}
	// }}}
	// {{{ getDonatedTo()

	/**
	 * Returns the current credit amount in the cadre's bank
	 *
	 * @return boolean
	 */
	public function getDonatedTo($to = null){
		if (is_null($to)) $to = $this->getCadre();
		
		$sql = 'SELECT SUM(`amount`) FROM `roster_cadre_bank` '
					.'WHERE cadre = "' . $to->data['id'] . '" AND `source` = "' . $this->getID() . '"';

		return $this->db->getOne($sql);
	}
	// }}}
	
	public function hasMedal(bhg_medalboard_medal $medal){
		try {
			$return = bhg_medalboard::getAwards(array('recipient' => $this, 'medal' => $medal));
			if ($return->count()) return true; 
			else return false;
		} catch (Exception $e) {
			return false;
		}
	}
	
	// {{{ handleRank()

	/**
	 * Utility function to handle Rank/Position changes
	 *
	 * @return boolean
	 */
	public function handleRank() {

		if ($this->getPosition()->isTrainee()) {

			if ($this->hasShip() && $this->hasCompletedCoreExam()) {

				$makehunter = true;

			}

		}
		
		if ($this->getDivision()->isCadre() && (
			$this->getPosition()->isEqualTo(bhg_roster::getPosition(14)) ||
			$this->getPosition()->isEqualTo(bhg_roster::getPosition(22)) ||
			$this->getPosition()->isEqualTo(bhg_roster::getPosition(19)))){
			
			if (!($this->getPosition()->isEqualTo(bhg_roster::getPosition(13)) || 
				$this->getPosition()->isEqualTo(bhg_roster::getPosition(28)))){
				
				$makehunter = true;
				
			}
			
		} elseif ($this->getDivision()->isEqualTo(bhg_roster::getDivision(12)) && 
				!$this->getPosition()->isEqualTo(bhg_roster::getPosition(19))){
			
			$this->setPosition(bhg_roster::getPosition(19));
			$this->setCadreRank(bhg_roster::getRank(25));
			
		} elseif ($this->getDivision()->isEqualTo(bhg_roster::getDivision(16)) && 
				!$this->getPosition()->isEqualTo(bhg_roster::getPosition(22))) {
			
			$this->setPosition(bhg_roster::getPosition(22));
			$this->setCadreRank(bhg_roster::getRank(25));
			
		}

		if ($makehunter === true || $this->getPosition()->isEqualTo(bhg_roster::getPosition(14))){
			if ($this->hasMedal(bhg_medalboard::getMedal(68))) {

				$this->setPosition(bhg_roster::getPosition(28));

			} elseif ($this->hasMedal(bhg_medalboard::getMedal(4))) {

				$this->setPosition(bhg_roster::getPosition(13));

			} elseif (!$this->getPosition()->isEqualTo(bhg_roster::getPosition(14))){
				
				$this->setPosition(bhg_roster::getPosition(14));
				
			}
		}
		
		if ($this->getDivision()->isEqualTo(bhg_roster::getDivision(26))) {

			$this->setLHA(true);

		}

		if ($this->inCadre()) {
			
			$filter['division'] = $this->getCadre();
			$filter['manuallyset'] = false;
			$ranks = $GLOBALS['bhg']->roster->getRanks($filter);
			
			foreach ($ranks as $rank){
				
				if ($rank->isDeposit())
					if ($rank->getRequiredCredits() <= $this->getDonatedTo()){ $newrank = $rank; break; }
					
				if ($rank->isRank())
					if ($rank->getRequiredCredits() <= $this->getRankCredits()){ $newrank = $rank; break; }
					
			}

			if (!is_null($newrank)
					&& !$newrank->isEqualTo($this->getCadreRank())
					&& (!$this->getCadreRank()->isManuallySet() || $this->getCadre()->getDefaultRank()->isEqualTo($this->getCadreRank()))) {

				$this->setCadreRank($newrank);
			}
		}
		
		if (!$this->getRank()->isManuallySet()) {
			if ($this->getPosition()->isTrainee()) {
				$ranks = $GLOBALS['bhg']->roster->getRanks(array(
							'alwaysavailable' => true,
							'manuallyset' => false,
							'cadre'	=> false,
							));
			} else {
				$ranks = $GLOBALS['bhg']->roster->getRanks(array(
							'manuallyset' => false,
							'cadre' => false,
							));
			}

			$newrank = null;
			
			foreach ($ranks as $rank) {

				if ($rank->getRequiredCredits() <= $this->getRankCredits()) {

					$newrank = $rank;

					break;

				}

			}

			if (!is_null($newrank)
					&& !$rank->isEqualTo($this->getRank())) {

				$this->setRank($rank);

			}

		}

		return true;

	}

	// }}}
	// {{{ canCreateCadre()
	
	/**
	 * Evaluates the ability of a hunter's ability to create a cadre
	 * @param  boolean
	 * @return boolean
	 */
	public function canCreateCadre($confederate = false){
		if ($this->inCadre() || ($confederate && $this->getAccountBalance() < 2000000) || $this->hasPendingCadreRequest()) return false;

		$search = array(
			'person'	=> $this,
			'type'		=> BHG_HISTORY_DIVISION,
			'item1'		=> 10,
			'limit'		=> 1,
			);
			
		$commission = $GLOBALS['bhg']->history->getEvents($search)->count() == 1;
		
		$search['type'] = BHG_HISTORY_POSITION; 
		$search['item1'] = array(11,7,36,35,33,32);
		$position = $GLOBALS['bhg']->history->getEvents($search)->count() == 1;	
		
		return (($this->getRank()->getSortOrder() <= 9 || $commission || $position) != $confederate);
	}
	// }}}
}

?>
