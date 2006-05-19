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
		$this->__blackListVar('set', array('md5password', 'passwd', 'redoranks', 'rankcredits', 'accountbalance'));
		$this->__addBooleanFields(array('ship', 'completedcoreexam'));
		$this->__addFieldMap(array(
					'rank' => 'bhg_roster_rank',
					'division' => 'bhg_roster_division',
					'position' => 'bhg_roster_position',
					'cadre' => 'bhg_roster_cadre',
					'previousdivision' => 'bhg_roster_division',
					));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addHistoryMap(array(
					'rank' => BHG_HISTORY_RANK,
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

			$hash = $this->db->getOne('SELECT PASSWORD(?)', array($password));

			return (strtolower($hash) == strtolower($this->data['passwd']));

		} else {

			return (strtolower(md5($password)) == strtolower($this->data['md5Password']));

		}

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

			throw bhg_not_found('This person has not yet been transfered.');

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

		return $this->getRank()->getAbbrev().' '.$this->getName();

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
	// {{{ getIDLine()

	/**
	 * Get the ID Line of this person
	 *
	 * @param boolean True for the full ID line, false for the short version.
	 * @return string
	 */
	public function getIDLine($showFull = false) {

		$div = $this->getDivision()->getName();

		if (strlen($special = $this->getPosition()->getSpecialDivision()) > 0)
			$div = $special;

		$idline = $this->getRank()->getAbbrev()
			.'/'
			.$this->getName()
			.'/'
			.$div
			.'/BHG -'
			.$this->getPosition()->getAbbrev();

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
						
						$awards = $GLOBALS['bhg']->medalboard->getAwards(array('medal'     => $medal,
																																	 'recipient' => $this));

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

		return !($this->data['division'] == 11 || $this->data['division'] == 12);

	}

	// }}}
	// {{{ inCadre()

	/**
	 * Is this person in a cadre?
	 *
	 * @param bhg_roster_cadre
	 * @return boolean
	 */
	public function inCadre($cadre = null) {

		if (is_null($cadre)) {

			return $this->data['cadre'] != 0;

		} else {

			if ($this->data['cadre'] == 0)
				return false;

			return $cadre->isEqualTo($this->getCadre());

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

		if ($this->data['cadre'] == 0)
			return false;

		return $this->isEqualTo($this->getCadre()->getLeader());

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

		return $division->isEqualTo($this->getDivision());

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
						'accountbalance' => array("(accountbalance + $credits)", true),
						));

			$this->__recordHistoryEvent(BHG_HISTORY_CREDIT, $this, $awarder->getID(), $credits, $this->getRankCredits(), $reason);

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
	// {{{ withdrawAccount()

	/**
	 * Withdraw credits from account balance
	 *
	 * @param integer Cost of purchase
	 * @param string The location that the withdrawl was done
	 * @param string The reason for the withdrawl
	 * @return boolean
	 */
	public function withdrawAccount($credits, $from, $for = '') {

		if ($GLOBALS['bhg']->hasPerm('purchase')) {
			
			$result = $this->__saveValue(array(
						'accountbalance' => array("(accountbalance - $credits)", true),
						));

			$this->__recordHistoryEvent(BHG_HISTORY_ACCOUNT, $this, $from, $for, $credits);

			return $result;

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ depositAccount()

	/**
	 * Make a deposit into the account
	 *
	 * @param integer amount of deposit
	 * @param string The location that the deposit was done
	 * @param string The reason for the deposit
	 * @return boolean
	 */
	public function depositAccount($credits, $from, $for = '') {

		return $this->withdrawAccount(-$credits, $from, $for);

	}

	// }}}

	// {{{ requestTransfer()
	
	/**
	 * Request a transfer to a new division for this person
	 *
	 * @param object bhg_roster_division
	 * @return boolean
	 */
	public function requestTransfer(bhg_roster_division $target) {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			return $this->__createRecord('roster_pending_transfer',
					array(
						'person' => $this->getID(),
						'target' => $target->getID(),
						));

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

			if (	 (	 $this->getPosition()->isEqualTo(bhg_roster::getPosition(11))
							|| $this->getPosition()->isEqualTo(bhg_roster::getPosition(12)))
					&& $this->getDivision()->isEqualTo($target, true)) {

				return $this->setPosition(bhg_roster::getPosition(14));

			}

			return $this->setDivision($target);

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

	// {{{ handleRank()

	/**
	 * Utility function to handle Rank/Position changes
	 *
	 * @return boolean
	 */
	public function handleRank() {

		if ($this->getPosition()->isTrainee()) {

			if ($this->hasShip() && $this->hasCompletedCoreExam()) {

				$this->setPosition(bhg_roster::getPosition(14));

			}

		}

		if ($this->getPosition()->isEqualTo(bhg_roster::getPosition(14))) {

			if ($this->hasMedal(bhg_medalboard::getMedal(68))) {

				$this->setPosition(bhg_roster::getPosition(28));

			} elseif ($this->hasMedal(bhg_medalboard::getMedal(4))) {

				$this->setPosition(bhg_roster::getPosition(13));

			}

		}

		if ($this->getRank()->isManuallySet()) {

			if ($this->getPosition()->isTrainee()) {

				$ranks = $GLOBALS['gen3']->getRanks(array(
							'alwaysavailable' => true,
							'manuallyset' => false,
							));

			} else {

				$ranks = $GLOBALS['gen3']->getRanks(array(
							'manuallyset' => false,
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

}

?>
