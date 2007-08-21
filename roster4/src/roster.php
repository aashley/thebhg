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
 * Roster Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster extends bhg_entry {

	// {{{ getCadre() [static]

	/**
	 * Load a specific Cadre
	 *
	 * @param integer
	 * @return bhg_roster_divisions
	 */
	static public function getCadre($id) {

		return bhg::loadObject('bhg_roster_division', $id);

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

			return new bhg_core_list('bhg_roster_division', $results);

		}

	}

	// }}}
	// {{{ getDivision() [static]

	/**
	 * Load a specific Division
	 *
	 * @param integer
	 * @return bhg_roster_division
	 */
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
	// {{{ getDivisionCategory() [static]

	/**
	 * Load a specific Division Category
	 *
	 * @param integer
	 * @return bhg_roster_division_category
	 */
	static public function getDivisionCategory($id) {

		return bhg::loadObject('bhg_roster_division_category', $id);

	}

	// }}}
	// {{{ getKabal() [static]

	/**
	 * Load a specific Kabal
	 * 
	 * @param integer
	 * @return bhg_roster_kabal
	 */
	static public function getKabal($id) {

		return bhg::loadObject('bhg_roster_kabal', $id);

	}
	
	// }}}
	// {{{ getKabals()

	/**
	 * Get all kabals in the system
	 *
	 * @param array Filters to select which kabals to load
	 * @return bhg_core_list
	 */
	public function getKabals($filter = array()) {

		try {

			$filter['category'] = bhg_roster::getDivisionCategory(2);

			return new bhg_core_list('bhg_roster_kabal', $this->getDivisions($filter)->items);

		} catch (Exception $e) {

			throw $e;

		}

	}

	// }}}
	// {{{ getNewPerson() [static]

	/**
	 * Load a specific new member application
	 *
	 * @param integer
	 * @return bhg_roster_new_person
	 */
	static public function getNewPersion($id) {

		return bhg::loadObject('bhg_roster_new_person', $id);

	}

	// }}}
	// {{{ getPendingCredit() [static]

	/**
	 * Load a specific pending credit
	 *
	 * @param integer
	 * @return bhg_roster_pending_credit
	 */
	static public function getPendingCredit($id) {

		return bhg::loadObject('bhg_roster_pending_credit', $id);

	}

	// }}}
	// {{{ getPendingCredits()

	/**
	 * Get all pending_credits in the system
	 *
	 * @param array Filters to select which pending_credits to load
	 * @return bhg_core_list
	 */
	public function getPendingCredits($filter = array()) {

		$sql = 'SELECT roster_pending_credit.id '
					.'FROM roster_pending_credit ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'roster_pending_credit.datedeleted IS NULL ';

		if (isset($filter['recipient']) && $filter['recipient'] instanceof bhg_roster_person)
			$sqlfilters[] = 'roster_pending_credit.recipient = '.$filter['recipient']->getID().' ';

		if (isset($filter['awarder']) && $filter['awarder'] instanceof bhg_roster_person)
			$sqlfilters[] = 'roster_pending_credit.awarder = '.$filter['awarder']->getID().' ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY roster_pending_credit.datecreated ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of pending credits.', $results);

		} else {

			return new bhg_core_list('bhg_roster_pending_credit', $results);

		}

	}

	// }}}
	// {{{ getPendingMedal() [static]

	/**
	 * Load a specific pending medal
	 *
	 * @param integer
	 * @return bhg_roster_pending_medal
	 */
	static public function getPendingMedal($id) {

		return bhg::loadObject('bhg_roster_pending_medal', $id);

	}

	// }}}
	// {{{ getPendingMedals()

	/**
	 * Get all pending_medals in the system
	 *
	 * @param array Filters to select which pending_medals to load
	 * @return bhg_core_list
	 */
	public function getPendingMedals($filter = array()) {

		$sql = 'SELECT roster_pending_medal.id '
					.'FROM roster_pending_medal ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'roster_pending_medal.datedeleted IS NULL ';

		if (isset($filter['recipient']) && $filter['recipient'] instanceof bhg_roster_person)
			$sqlfilters[] = 'roster_pending_medal.recipient = '.$filter['recipient']->getID().' ';

		if (isset($filter['awarder']) && $filter['awarder'] instanceof bhg_roster_person)
			$sqlfilters[] = 'roster_pending_medal.awarder = '.$filter['awarder']->getID().' ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY roster_pending_medal.datecreated ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of pending medals.', $results);

		} else {

			return new bhg_core_list('bhg_roster_pending_medal', $results);

		}

	}

	// }}}
	// {{{ getPendingTransfer() [static]

	/**
	 * Load a specific pending transfer
	 *
	 * @param integer
	 * @return bhg_roster_pending_transfer
	 */
	static public function getPendingTransfer($id) {

		return bhg::loadObject('bhg_roster_pending_transfer', $id);

	}

	// }}}
	// {{{ getPendingTransfers()

	/**
	 * Get all pending_transfers in the system
	 *
	 * @param array Filters to select which pending_transfers to load
	 * @return bhg_core_list
	 */
	public function getPendingTransfers($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_pending_transfer ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['person']) && $filter['person'] instanceof bhg_roster_person)
			$sqlfilters[] = 'person = '.$filter['person']->getID().' ';

		if (isset($filter['target']) && $filter['target'] instanceof bhg_roster_person)
			$sqlfilters[] = 'target = '.$filter['target']->getID().' ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY datecreated ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of pending transfers.', $results);

		} else {

			return new bhg_core_list('bhg_roster_pending_transfer', $results);

		}

	}

	// }}}
	// {{{ getPendingCadre() [static]

	/**
	 * Load a specific pending cadre
	 *
	 * @param integer
	 * @return bhg_roster_pending_cadre
	 */
	static public function getPendingCadre($id) {

		return bhg::loadObject('bhg_roster_pending_cadre', $id);

	}

	// }}}
	// {{{ getPendingCadres()

	/**
	 * Get all pending_cadres in the system
	 *
	 * @param array Filters to select which pending_cadres to load
	 * @return bhg_core_list
	 */
	public function getPendingCadres($filter = array()) {

		$sql = 'SELECT id '
					.'FROM roster_pending_cadre ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['leader']) && $filter['leader'] instanceof bhg_roster_person)
			$sqlfilters[] = 'leader = '.$filter['leader']->getID().' ';

		if (isset($filter['member']) && $filter['member'] instanceof bhg_roster_person){
			$or = array('leader = '.$filter['member']->getID().' ');
			for ($i = 1; $i <= 6; ++$i)
				$or[] = 'member' . $i . ' = '.$filter['member']->getID().' ';
				
			$sqlfilters[] = '((' . implode(') OR (', $or) . '))';
		}

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY datecreated ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of pending cadres.', $results);

		} else {

			return new bhg_core_list('bhg_roster_pending_cadre', $results);

		}

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

		if (isset($filter['cadre'])
				&& $filter['cadre'] instanceof bhg_roster_division)
			$sqlfilters[] = '`division` = '.$this->db->quoteSmart($filter['cadre']->getID());

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
	// {{{ getPerson() [static]

	/**
	 * Load a specific person
	 *
	 * @param integer
	 * @return bhg_roster_person
	 */
	static public function getPerson($id) {

		return bhg::loadObject('bhg_roster_person', $id);

	}

	// }}}
	// {{{ getPosition() [static]

	/**
	 * Load a specific Position
	 *
	 * @param integer
	 * @return bhg_roster_position
	 */
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
	// {{{ getRank() [static]

	/**
	 * Load a specific Rank
	 *
	 * @param integer
	 * @return bhg_roster_rank
	 */
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
			
		if (isset($filter['cadre']))
			$sqlfilters[] = 'cadre = '.($filter['cadre'] ? '1' : '0');
			
		if (isset($filter['division'])
				&& $filter['division'] instanceof bhg_roster_division)
			$sqlfilters[] = '`division` = '.$this->db->quoteSmart($filter['division']->getID());
			
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
