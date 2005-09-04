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

		$sql = 'SELECT id '
					.'FROM bhg_roster_person ';

		$sqlfilters = array();

		if (isset($filter['deleted']) && $filter['deleted'] == true)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters);

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of people.', $results);

		} else {

			return new bhg_core_list('bhg_roster_person', $results);

		}

	}

	// }}}

}

?>
