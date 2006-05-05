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
 * Roster Pending Transfer Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_pending_transfer extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_pending_transfer', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person',
					'target' => 'bhg_roster_person',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	
	// {{{ approve()
	
	/**
	 * Approve this transfer request
	 *
	 * return boolean
	 */
	public function approve() {

		if ($GLOBALS['bhg']->hasPerm('god')) {

			$return = $this->getPerson()->transfer($this->getTarget());

			if ($return)
				$this->delete();

			return $return;

		} else {

			throw new bhg_coder_exception();

		}

	}

	// }}}
	// {{{ deny()

	/**
	 * Deny this transfer request
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
