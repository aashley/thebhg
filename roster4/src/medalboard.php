<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */

/**
 * MedalBoard Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */
class bhg_medalboard extends bhg_entry {

	// {{{ getAward()

	static public function getAward($id) {

		return bhg::loadObject('bhg_medalboard_award', $id);

	}

	// }}}
	// {{{ getAwards()

	/**
	 * Retrieves all medal awards made within the system.
	 *
	 * @param array Filters for the award list.
	 * Valid filters include:
	 * <ul>
	 * <li><i>awarder</i>: takes a bhg_roster_person object.
	 * <li><i>date</i>: takes an array, which is a date range to search within.
	 * The array should be (start, end), with both elements being either a Date
	 * object, or null to search from the beginning or end, respectively.</li>
	 * <li><i>group</i>: takes a bhg_medalboard_group object.</li>
	 * <li><i>medal</i>: takes a bhg_medalboard_medal object.</li>
	 * <li><i>recipient</i>: takes a bhg_roster_person object.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_medalboard_award objects.
	 */
	public function getAwards($filter = array()) {

		$sql = 'SELECT id '
					.'FROM medalboard_award ';

		$sqlfilters = array();

		if (isset($filter['awarder']) && $filter['awarder'] instanceof bhg_roster_person)
			$sqlfilters[] = 'awarder = '.$this->db->quoteSmart($filter['awarder']->getID());

		if (isset($filter['date']) && is_array($filter['date']) && count($filter['date']) == 2) {
			if ($filter['date'][0] instanceof Date)
				$sqlfilters[] = '`datecreated` >= '.$this->db->quoteSmart($filter['date'][0]->getDate(DATE_FORMAT_UNIXTIME));
			
			if ($filter['date'][1] instanceof Date)
				$sqlfilters[] = '`datecreated` <= '.$this->db->quoteSmart($filter['date'][1]->getDate(DATE_FORMAT_UNIXTIME));
		}

		if (isset($filter['group']) && $filter['group'] instanceof bhg_medalboard_group) {
			$medals = array();
			foreach ($filter['group']->getMedals() as $medal)
				$medals[] = $this->db->quoteSmart($medal->getID());
			$sqlfilters[] = 'medal IN ('.implode(', ', $medals).')';
		}

		if (isset($filter['medal']) && $filter['medal'] instanceof bhg_medalboard_medal)
			$sqlfilters[] = 'medal = '.$this->db->quoteSmart($filter['medal']->getID());

		if (isset($filter['recipient']) && $filter['recipient'] instanceof bhg_roster_person)
			$sqlfilters[] = 'recipient = '.$this->db->quoteSmart($filter['recipient']->getID());

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal awards.', $results);

		} else {

			return new bhg_core_list('bhg_medalboard_award', $results);

		}

	}
	
	// }}}
	// {{{ getCategory()

	static public function getCategory($id) {

		return bhg::loadObject('bhg_medalboard_category', $id);

	}

	// }}}
	// {{{ getCategories()

	public function getCategories($filter = array()) {

		$sql = 'SELECT id '
					.'FROM medalboard_category ';

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY sortorder ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal board categories.', $result);

		} else {

			return new bhg_core_list('bhg_medalboard_category', $results);

		}

	}

	// }}}
	// {{{ getGroup()

	static public function getGroup($id) {

		return bhg::loadObject('bhg_medalboard_group', $id);

	}

	// }}}
	// {{{ getGroups()

	public function getGroups($filter = array()) {

		$sql = 'SELECT id '
					.'FROM medalboard_group ';

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['category']) && $filter['category'] instanceof bhg_medalboard_category)
			$sqlfilters[] = 'category = '.$this->db->quoteSmart($filter['category']->getID()).' ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY sortorder ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal board groups.', $result);

		} else {

			return new bhg_core_list('bhg_medalboard_group', $results);

		}

	}

	// }}}
	// {{{ getMedal()

	static public function getMedal($id) {

		return bhg::loadObject('bhg_medalboard_medal', $id);

	}

	// }}}
	// {{{ getMedals()

	public function getMedals($filter = array()) {

		$sql = 'SELECT id '
					.'FROM medalboard_medal ';

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['group']) && $filter['group'] instanceof bhg_medalboard_group)
			$sqlfilters[] = '`group` = '.$this->db->quoteSmart($filter['group']->getID());

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY sortorder ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal board medals.', $result);

		} else {

			return new bhg_core_list('bhg_medalboard_medal', $results);

		}

	}

	// }}}

}

?>
