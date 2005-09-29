<?php

class bhg_roster_division extends bhg_core_base {

	// {{{ __construct()

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

		$sql = 'SELECT id '
					.'FROM roster_person ';

		$sqlfilters = array('division = ?');

		if (isset($filter['deleted']) && $filter['deleted'] == true)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters);

		$results = $this->db->getCol($sql, 0, array($this->getID()));

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of people.', $results);

		} else {

			return new bhg_core_list('bhg_roster_person', $results);

		}

	}

	// }}}

}

?>
