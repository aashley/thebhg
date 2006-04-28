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
 * Roster Pending Credit Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_pending_credit extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_pending_credit', $id);
		$this->addFieldMap(array(
					'recipient'	=> 'bhg_roster_person',
					'awarder'		=> 'bhg_roster_division',
					));
		$this->__addBooleanFields(array('approved'));
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

			return $this->getRecipient()->awardCredits($this->getAmount(),
					$this->getAwarder(),
					$this->getReason());

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
