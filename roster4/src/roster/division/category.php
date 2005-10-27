<?php

class bhg_roster_division_category extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_division_category', $id);
		$this->__addBooleanFields(array('kabals'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getDivisions()

	/**
	 * Get all the divisions within this division category
	 *
	 * @param array Filters to select which divisions to load
	 * @return bhg_core_list
	 */
	public function getDivisions($filter = array()) {

		$filter['category'] = $this;

		return $GLOBALS['bhg']->roster->getDivisions($filter);

	}

	// }}}
	// {{{ getKabals()

	/**
	 * Get all the divisions within this division category
	 *
	 * @param array Filters to select which divisions to load
	 * @return bhg_core_list
	 */
	public function getKabals($filter = array()) {

		if (!$this->hasKabals())
			return new bhg_core_list('bhg_roster_kabal', array());

		$filter['category'] = $this;

		$divisions = $GLOBALS['bhg']->roster->getDivisions($filter);

		return new bhg_core_list('bhg_roster_kabal', $divisions->items);

	}

	// }}}

}

?>
