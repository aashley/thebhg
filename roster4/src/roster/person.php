<?php

class bhg_roster_person extends bhg_core_base {

	// {{{ __construct()

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
	// {{{ getIDLine()

	/**
	 * Get the ID Line of this person
	 *
	 * @return string
	 */
	public function getIDLine() {

		$idline = $this->getRank()->getAbbrev()
			.'/'
			.$this->getName()
			.'/'
			.$this->getDivision()->getName()
			.'/BHG -'
			.$this->getPosition()->getAbbrev();

		return $idline;

	}

	// }}}
	// {{{ getMedals()

	/**
	 * Retrieve All Medals awarded to this person
	 *
	 * @return bhg_core_list
	 */
	public function getMedals() {

		return $GLOBALS['bhg']->medalboard->getMedals(
				array(
					'recipient' => $this,
					));

	}

	// }}}

	// {{{ awardCredits()

	/**
	 * Add credits to this person's rank account
	 *
	 * @param integer Credits to award
	 * @return boolean
	 */
	public function awardCredits($credits, bhg_roster_person $awarder, $reason = '') {

		$result = $this->__saveValue(array(
					'rankcredits' => array("(rankcredits + $credits)", true),
					'accountbalance' => array("(accountbalance + $credits)", true),
					));

		$this->__recordHistoryEvent(BHG_HISTORY_CREDIT, $this, $awarder->getID(), $credits, $this->getRankCredits(), $reason);

		return $result;

	}

	// }}}
	// {{{ removeCredits()

	/**
	 * Remove credits from this person's rank account
	 *
	 * @param integer Credits to remove
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
	 * @return boolean
	 */
	public function withdrawAccount($credits, $from, $for = '') {

		$result = $this->__saveValue(array(
					'accountbalance' => array("(accountbalance - $credits)", true),
					));

		$this->__recordHistoryEvent(BHG_HISTORY_ACCOUNT, $this, $from, $for, $credits);

		return $result;

	}

	// }}}
	// {{{ depositAccount()

	/**
	 * Make a deposit into the account
	 *
	 * @param integer amount of deposit
	 * @return boolean
	 */
	public function depositAccount($credits, $from, $for = '') {

		return $this->withdrawAccount(-$credits, $from, $for);

	}

	// }}}

}

?>
