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
 * Roster Pending Medal Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_pending_medal extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_pending_medal', $id);
		$this->addFieldMap(array(
					'recipient'	=> 'bhg_roster_person',
					'awarder'		=> 'bhg_roster_division',
					));
		$this->__addBooleanFields(array('approved'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	
	// {{{ getMedal()
	
	/**
	 * Retrieve the Medal Group or Individual Medal this is attempting to award
	 *
	 * @return bhg_medalboard_group|bhg_medalboard_medal
	 */
	public function getMedal() {

		if ($this->getMedalType() == 'group') {

			return bhg_medalboard::getGroup($this->data['medal']);

		} else {

			return bhg_medalboard::getMedal($this->data['medal']);

		}

	}

	// }}}
	
	// {{{ approve()
	
	/**
	 * Approve this medal request
	 *
	 * return boolean
	 */
	public function approve() {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			return $this->getRecipient()->awardMedal($this->getMedal(),
					$this->getAwarder(),
					$this->getReason());

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ deny()

	/**
	 * Deny this medal request
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
