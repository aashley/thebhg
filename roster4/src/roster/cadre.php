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
 * Roster Cadre Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_cadre extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 * 
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_cadre', $id);
		$this->__addFieldMap(array(
					'leader' => 'bhg_roster_person',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getPeople()

	/**
	 * Get all people in this cadre
	 *
	 * @param array Filters to select which people to load
	 * @return bhg_core_list
	 */
	public function getPeople($filter = array()) {

		$filter['cadre'] = $this;

		return $GLOBALS['bhg']->roster->getPeople($filter);

	}

	// }}}

}

?>
