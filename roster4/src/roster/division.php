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
 * Roster Division Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_division extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_division', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_roster_division_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getPeople()

	/**
	 * Get all people in this division
	 *
	 * @param array Filters to select which people to load
	 * @return bhg_core_list
	 */
	public function getPeople($filter = array()) {

		$filter['division'] = $this;

		return $GLOBALS['bhg']->roster->getPeople($filter);

	}

	// }}}
	// {{{ isKabal()
	
	/**
	 * Is this division a Kabal?
	 *
	 * @return boolean
	 */
	public function isKabal() {

		if ($this instanceof bhg_roster_kabal)
			return true;

		return $this->getCategory()->hasKabals();

	}

	// }}}

}

?>
