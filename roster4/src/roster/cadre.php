<?php

class bhg_roster_cadre extends bhg_core_base {

	// {{{ __construct()

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
