<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev:$ $Date:$
 */

/**
 * Roster Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev:$ $Date:$
 */
class bhg_roster extends bhg_entry {

	// {{{ getCadre()

	static public function getCadre($id) {

		return bhg::loadObject('bhg_roster_cadre', $id);

	}

	// }}}
	// {{{ getCadres()

	/**
	 * Get all cadres in the system
	 *
	 * @param array Filters to select which cadres to load
	 * @return bhg_core_list
	 */
	public function getCadres($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_cadre ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY name ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of cadres.', $results);

		} else {

			return new bhg_core_list('bhg_roster_cadre', $results);

		}

	}

	// }}}
	// {{{ getDivision()

	static public function getDivision($id) {

		return bhg::loadObject('bhg_roster_division', $id);

	}
	
	// }}}
	// {{{ getDivisions()

	/**
	 * Get all divisions in the system
	 *
	 * @param array Filters to select which divisions to load
	 * @return bhg_core_list
	 */
	public function getDivisions($filter = array()) {

		$sql = 'SELECT roster_division.id '
					.'FROM roster_division, '
							 .'roster_division_category '
					.'WHERE roster_division.category = roster_division_category.id ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'roster_division.datedeleted IS NULL ';

		if (isset($filter['category']) && $filter['category'] instanceof bhg_roster_division_category)
			$sqlfilters[] = 'roster_division.category = '.$filter['category']->getID().' ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'AND '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY roster_division_category.sortorder ASC, '
										.'roster_division.name ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of divisions.', $results);

		} else {

			return new bhg_core_list('bhg_roster_division', $results);

		}

	}

	// }}}
	// {{{ getDivisionCategories()

	/**
	 * Get all division categories in the system
	 *
	 * @param array Filters to select which division categories to load
	 * @return bhg_core_list
	 */
	public function getDivisionCategories($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_division_category ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY sortorder ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of division categories.', $results);

		} else {

			return new bhg_core_list('bhg_roster_division_category', $results);

		}

	}

	// }}}
	// {{{ getDivisionCategory()

	static public function getDivisionCategory($id) {

		return bhg::loadObject('bhg_roster_division_category', $id);

	}

	// }}}
	// {{{ getKabal()

	static public function getKabal($id) {

		return bhg::loadObject('bhg_roster_kabal', $id);

	}
	
	// }}}
	// {{{ getNewPerson()

	static public function getNewPersion($id) {

		return bhg::loadObject('bhg_roster_new_person', $id);

	}

	// }}}
	// {{{ getPerson()

	static public function getPerson($id) {

		return bhg::loadObject('bhg_roster_person', $id);

	}

	// }}}
	// {{{ getPeople()

	/**
	 * Returns a set of people within the system.
	 *
	 * @param array Filters to select which people to load. Filters available
	 * include name, email, division, position, rank, ircnicks, and deleted.
	 * @return bhg_core_list
	 */
	public function getPeople($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_person ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'
										 .$this->db->escapeSimple($filter['name'])
										 .'%"';

		if (isset($filter['email']))
			$sqlfilters[] = '`email` LIKE "%'
										 .$this->db->escapeSimple($filter['email'])
										 .'%"';

		if (isset($filter['ircnicks']))
			$sqlfilters[] = '`ircnicks` LIKE "%'
										 .$this->db->escapeSimple($filter['ircnicks'])
										 .'%"';

		if (isset($filter['division'])
		 && $filter['division'] instanceof bhg_roster_division)
			$sqlfilters[] = '`division` = '.$this->db->quoteSmart($filter['division']->getID());

		if (isset($filter['position'])
		 && $filter['position'] instanceof bhg_roster_position)
			$sqlfilters[] = '`position` = '.$this->db->quoteSmart($filter['position']->getID());

		if (isset($filter['rank'])
		 && $filter['rank'] instanceof bhg_roster_rank)
			$sqlfilters[] = '`rank` = '.$this->db->quoteSmart($filter['rank']->getID());

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of people.', $results);

		} else {

			return new bhg_core_list('bhg_roster_person', $results);

		}

	}

	// }}}
	// {{{ getPosition()

	static public function getPosition($id) {

		return bhg::loadObject('bhg_roster_position', $id);

	}

	// }}}
	// {{{ getPositions()

	/**
	 * Get all positions in the system
	 *
	 * @param array Filters to select which positions to load
	 * @return bhg_core_list
	 */
	public function getPositions($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_position ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY sortorder ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of positions.', $results);

		} else {

			return new bhg_core_list('bhg_roster_position', $results);

		}

	}

	// }}}
	// {{{ getRank()

	static public function getRank($id) {

		return bhg::loadObject('bhg_roster_rank', $id);

	}

	// }}}
	// {{{ getRanks()

	/**
	 * Get all ranks in the system
	 *
	 * @param array Filters to select which ranks to load
	 * @return bhg_core_list
	 */
	public function getRanks($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_rank ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['alwaysavailable']))
			$sqlfilters[] = 'alwaysavailable = '.($filter['alwaysavailable'] ? '1' : '0');

		if (isset($filter['unlimitedcredits']))
			$sqlfilters[] = 'unlimitedcredits = '.($filter['unlimitedcredits'] ? '1' : '0');

		if (isset($filter['manuallyset']))
			$sqlfilters[] = 'manuallyset = '.($filter['manuallyset'] ? '1' : '0');

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY sortorder ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of ranks.', $results);

		} else {

			return new bhg_core_list('bhg_roster_rank', $results);

		}

	}

	// }}}

}

?>
