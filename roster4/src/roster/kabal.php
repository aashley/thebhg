<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Rosteg
 * @Version $Rev$ $Date$
 */

/**
 * Roster Kabal Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_kabal extends bhg_roster_division {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct($id);
		$this->__addFieldMap(array(
					'category' => 'bhg_roster_division_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getChief()
	
	/**
	 * Get the Chief of this Kabal
	 *
	 * @return mixed bhg_roster_person if there is a Chief else false
	 */
	public function getChief() {

		$filter = array(
				'division' => $this,
				'position' => bhg_roster::getPosition(11),
				);

		$p = $GLOBALS['bhg']->roster->getPeople($filter);

		if ($p->count() >= 1) {
			
			return $p->getItem(0);

		} else {

			return false;

		}

	}

	// }}}
	// {{{ getCRA()
	
	/**
	 * Get the CRA of this Kabal
	 *
	 * @return mixed bhg_roster_person if there is a CRA else false
	 */
	public function getCRA() {

		$filter = array(
				'division' => $this,
				'position' => bhg_roster::getPosition(12),
				);

		$p = $GLOBALS['bhg']->roster->getPeople($filter);

		if ($p->count() >= 1) {
			
			return $p->getItem(0);

		} else {

			return false;

		}

	}

	// }}}

}

?>
